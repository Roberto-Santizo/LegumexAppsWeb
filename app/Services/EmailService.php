<?php

namespace App\Services;

use Carbon\Carbon;
use Microsoft\Graph\Graph;
use Microsoft\Graph\Model\Message;
use Microsoft\Graph\Model\ItemBody;
use Microsoft\Graph\Model\Recipient;
use Microsoft\Graph\Model\EmailAddress;

class EmailService
{

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

    public function sendNotificationNewOT($ot)
    {
        // Obtiene el token de acceso
        $accessToken = $this->getAccessToken();

        $graph = new Graph();
        $graph->setAccessToken($accessToken);

        $userId = 'mantoapps@legumex.net';

        $recipient1 = new Recipient();
        $recipient1->setEmailAddress(new EmailAddress(['address' => 'soportetecnico.tejar@legumex.net']));

        $recipient2 = new Recipient();
        $recipient2->setEmailAddress(new EmailAddress(['address' => 'manto.parramos@legumex.net']));

        $recipient3 = new Recipient();
        $recipient3->setEmailAddress(new EmailAddress(['address' => 'auxmantotejar@legumex.net']));

        $recipient4 = new Recipient();
        $recipient4->setEmailAddress(new EmailAddress(['address' => 'auxmantoparramos@legumex.net']));

        $recipient5 = new Recipient();
        $recipient5->setEmailAddress(new EmailAddress(['address' => 'manto.tejar@legumex.net']));

        $recipient6 = new Recipient();
        $recipient6->setEmailAddress(new EmailAddress(['address' => 'mramila.jr@legumex.net']));


        $message = new Message();
        $message->setSubject('Nueva orden de trabajo');
        $message->setBody([
            'content' => $this->buildsendNotificationNewOTMessage($ot),
            'contentType' => 'HTML'
        ]);
        $message->setToRecipients([$recipient1, $recipient2,$recipient3, $recipient4, $recipient5, $recipient6]);

        $graph->createRequest("POST", "/users/$userId/sendMail")
            ->attachBody([
                'message' => $message,
                'saveToSentItems' => "true"
            ])
            ->execute();
    }


    //Controuccion de diferentes correos
    public function buildsendNotificationNewOTMessage($ot)
    {
        $url = 'https://legumexapps.domcloud.dev/mantenimiento/administracion/ordenes-trabajos/1';
        $anio = Carbon::today()->year;
        $area = $ot->area->area;
        $ubicacion = $ot->elemento->elemento;
        $planta = $ot->planta->name;
        $problema = $ot->problema_detectado;
        $urgencia = ($ot->urgencia == 1) ? 'URGENTE' : (($ot->urgencia === 2) ? 'MEDIA' : 'BAJA');

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
                                    <tr>
                                        <td style="background-color: #4a90e2; padding: 20px; text-align: center;">
                                            <h1 style="color: #ffffff; margin: 0; font-size: 24px;">¡Se ha creado una nueva orden de trabajo!</h1>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td style="padding: 20px;">
                                            <h2 style="color: #333333; font-size: 20px;">Se ha registrado una orden de trabajo con la siguiente información: </h2>
                                            <p style="margin-bottom: 20px;">Planta: $planta</p>
                                            <p style="margin-bottom: 20px;">Área: $area</p>
                                            <p style="margin-bottom: 20px;">Equipo: $ubicacion</p>
                                            <p style="margin-bottom: 20px;">Problema detectado: $problema</p>
                                            <p style="margin-bottom: 20px;">Urgencia: $urgencia</p>

                                            <table role="presentation" style="width: 100%; border-collapse: collapse; margin-bottom: 20px; text-align: center;">
                                                <tr>
                                                    <td>
                                                        <a href="$url" style="background-color: #4a90e2; color: #ffffff; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block;">Click Aquí para Ver</a>
                                                    </td>
                                                </tr>
                                            </table>

                                        </td>
                                    </tr>

                                    <tr>
                                        <td style="background-color: #f0f0f0; padding: 20px; text-align: center; font-size: 14px; color: #666666;">
                                            <p style="margin: 0 0 10px 0;">© $anio Agroindustria Legumex. Todos los derechos reservados.</p>
                                            <p style="margin: 0;">
                                                Este correo ha sido enviado automáticamente y tiene como propósito notificarle.
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
