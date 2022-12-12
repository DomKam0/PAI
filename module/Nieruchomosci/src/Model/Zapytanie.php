<?php

namespace Nieruchomosci\Model;

use Laminas\Mail\Transport\Smtp as SmtpTransport;
use Laminas\Mime\Message as MimeMessage;
use Laminas\Mail\Transport\SmtpOptions;
use Laminas\Mime\Part as MimePart;
use Nieruchomosci\Model\Oferta;
use Laminas\Mail\Message;
use Laminas\Mime\Mime;


class Zapytanie
{
    private array $smtpTransportConfig;

    private array $from;

    private string $to;

    public function __construct(array $config)
    {
        $this->from = $config['from'];
        $this->to = $config['to'];
        unset($config['from']);
        unset($config['to']);

        $this->smtpTransportConfig = $config;
    }

    /**
     * Wysya maila z zapytaniem ofertowym.
     *
     * @param array  $daneOferty
     * @param string $tresc
     * @return bool
     */
    public function wyslij($daneOferty, string $email_odbiorca, string $tresc, string $email_nadawca, string $telefon, $plik) : bool
    {
        $transport = new SmtpTransport();
        $options = new SmtpOptions($this->smtpTransportConfig);
        $transport->setOptions($options);

        $part = new MimePart("Klient wyraził zainteresowanie ofertą numer *$daneOferty[numer]* o treści:\n\n$tresc");
        $part->type = 'text/plain';
        $part->charset = 'utf-8';

        $partA = new MimePart("\nAdres email kontaktowy klienta: $email_nadawca");
        $partA->type = 'text/plain';
        $partA->charset = 'utf-8';

        $partB = new MimePart("\nTelefon klienta: $telefon");
        $partB->type = 'text/plain';
        $partB->charset = 'utf-8';

        $partC = new MimePart($plik);
        $partC->type = 'application/pdf';
        $partC->filename = "\noferta_$daneOferty[numer].pdf";
        $partC->disposition = Mime::DISPOSITION_ATTACHMENT;
        $partC->encoding = Mime::ENCODING_BASE64;

        $body = new MimeMessage();
        $body->setParts([$part, $partA, $partB, $partC]);

        $message = new Message();
        $message->setEncoding('UTF-8');
        $message->setFrom($this->from['email'], $this->from['name']); // konto do wysyłania maili z serwisu
        $message->addTo($this->$email_odbiorca, "Administrator"); // osoba obsługująca zgłoszenia
        $message->setSubject("Zainteresowanie ofertą");
        $message->setBody($body);

        try {
            $transport->send($message);

            return true;
        } catch (\Exception $e) {
            echo $e->getMessage();

            return false;
        }
    }
}
