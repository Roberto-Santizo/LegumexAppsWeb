<?php

namespace App\Services;

use Microsoft\Graph\Graph;
use App\Models\OrdenTrabajo;
use Illuminate\Support\Carbon;
use Microsoft\Graph\Model\Message;
use Microsoft\Graph\Model\Recipient;
use Microsoft\Graph\Model\EmailAddress;

class NotificacionOrdenTrabajoPendienteService
{
    public function checkSendNotification()
    {
        $fechaActual = Carbon::now();
        $fechaLimite = $fechaActual->addDay(); 
        $ordenesPendientes = OrdenTrabajo::where('estado_id', 1)
            ->where('mecanico_id', null)
            ->where(function ($query) use ($fechaActual, $fechaLimite) {
                $query->whereDate('fecha_propuesta', $fechaLimite->toDateString()) 
                    ->orWhereDate('fecha_propuesta', '<', $fechaActual->toDateString()); 
            })
            ->with('estado')
            ->get();
        if ($ordenesPendientes->count() > 0) {
            $this->sendEmailNotification($ordenesPendientes);
        }
    }

    private function sendEmailNotification($ordenesPendientes)
    {
        // Obtiene el token de acceso
        $accessToken = $this->getAccessToken();

        $graph = new Graph();
        $graph->setAccessToken($accessToken);

        $userId = 'mantoapps@legumex.net';

        $recipient1 = new Recipient();
        $recipient1->setEmailAddress(new EmailAddress(['address' => 'soportetecnico.tejar@legumex.net']));

        $recipient2 = new Recipient();
        $recipient2->setEmailAddress(new EmailAddress(['address' => 'pedro.soto@legumex.net']));

        $message = new Message();
        $message->setSubject('Notificación de órdenes de trabajo pendientes');
        $message->setBody([
            'content' => $this->buildMessageBody($ordenesPendientes),
            'contentType' => 'HTML'
        ]);
        $message->setToRecipients([$recipient1]);

        $graph->createRequest("POST", "/users/$userId/sendMail")
            ->attachBody([
                'message' => $message,
                'saveToSentItems' => "true"
            ])
            ->execute();
    }

    private function getAccessToken()
    {
        // Genera el token de acceso utilizando Client Credentials Grant
        $guzzle = new \GuzzleHttp\Client();

        $url = 'https://login.microsoftonline.com/' . env('MICROSOFT_TENANT_ID') . '/oauth2/v2.0/token';
        $tokenResponse = $guzzle->post($url, [
            'form_params' => [
                'client_id' => env('MICROSOFT_CLIENT_ID'),
                'client_secret' => env('MICROSOFT_CLIENT_SECRET'),
                'scope' => 'https://graph.microsoft.com/.default',
                'grant_type' => 'client_credentials',
            ],
        ]);

        $token = json_decode($tokenResponse->getBody()->getContents(), true);
        return $token['access_token'];
    }

    private function buildMessageBody($ordenesPendientes)
    {
        $message = "<div style='font-family: Arial, sans-serif;'>";
        $message .= "<p style='font-size: 25px; font-weight: bold;'>¡Se acerca la fecha de entrega!</p>";
        $message .= "<p style='font-size: 14px; font-weight: bold;'>Existen ordenes que su fecha de entrega se acerca y no cuentan con un mecánico.</p>";
        
        $url = 'https://legumexapps.domcloud.dev/mantenimiento/administracion/ordenes-trabajos/1';
        $message .= "<a href='$url'>
                        Click Aquí para Ver
                    </a>";

        $message .= "</div>";

        return $message;
    }
}
