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
        $recipient2->setEmailAddress(new EmailAddress(['address' => 'robertsantizo76@gmail.com']));

        $message = new Message();
        $message->setSubject('Notificación de órdenes de trabajo pendientes');
        $message->setBody([
            'content' => $this->buildMessageBody($ordenesPendientes),
            'contentType' => 'HTML'
        ]);
        $message->setToRecipients([$recipient1, $recipient2]);

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
        $url = 'https://legumexapps.domcloud.dev/mantenimiento/administracion/ordenes-trabajos/1';

        $anio = Carbon::today()->year;
        $message = <<<HTML
                <!DOCTYPE html>
                <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>Legumex</title>
                </head>
                <body style="margin: 0; padding: 0; font-family: Arial, sans-serif; font-size: 16px; line-height: 1.5; color: #333333; background-color: #f4f4f4;">
                    <table role="presentation" style="width: 100%; border-collapse: collapse;">
                        <tr>
                            <td align="center" style="padding: 20px 0;">
                                <table role="presentation" style="width: 600px; max-width: 100%; border-collapse: collapse; background-color: #ffffff; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
                                    <!-- Header -->
                                    <tr>
                                        <td style="background-color: #4a90e2; padding: 20px; text-align: center;">
                                            <h1 style="color: #ffffff; margin: 0; font-size: 24px;">¡Se acerca la fecha de entrega!</h1>
                                        </td>
                                    </tr>

                                    <!-- Main Content -->
                                    <tr>
                                        <td style="padding: 20px;">
                                            <h2 style="color: #333333; font-size: 20px;">Existen órdenes que su fecha de entrega se acerca y no cuentan con un mecánico.</h2>
                                            <p style="margin-bottom: 20px;">Para revisar estas órdenes y asignar a un mecánico, haz clic en el siguiente enlace.</p>

                                            <!-- Action Link -->
                                            <table role="presentation" style="width: 100%; border-collapse: collapse; margin-bottom: 20px; text-align: center;">
                                                <tr>
                                                    <td>
                                                        <a href="$url" style="background-color: #4a90e2; color: #ffffff; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block;">Click Aquí para Ver</a>
                                                    </td>
                                                </tr>
                                            </table>

                                        </td>
                                    </tr>

                                    <!-- Footer -->
                                    <tr>
                                        <td style="background-color: #f0f0f0; padding: 20px; text-align: center; font-size: 14px; color: #666666;">
                                            <p style="margin: 0 0 10px 0;">© $anio Agroindustria Legumex. Todos los derechos reservados.</p>
                                            <p style="margin: 0;">
                                                Este correo es enviado automáticamente y se utiliza con motivo de notificación.
                                            </p>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </body>
                </html>
                HTML;

        return $message;
    }
}
