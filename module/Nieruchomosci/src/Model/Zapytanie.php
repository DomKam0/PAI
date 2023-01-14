<?php

namespace Nieruchomosci\Model;

use Laminas\Mail\Message;
use Laminas\Mail\Transport\Smtp as SmtpTransport;
use Laminas\Mail\Transport\SmtpOptions;
use Laminas\Mime\Message as MimeMessage;
use Laminas\Mime\Part as MimePart;

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
    public function wyslij($daneOferty, string $tresc): bool
    {
        $transport = new SmtpTransport();
        $options = new SmtpOptions($this->smtpTransportConfig);
        $transport->setOptions($options);

        $part = new MimePart("Klient wyraził zainteresowanie ofertą numer *$daneOferty[numer]* o treści:\n\n$tresc");
        $part->type = 'text/plain';
        $part->charset = 'utf-8';

        $body = new MimeMessage();
        $body->setParts([$part]);

        $message = new Message();
        $message->setEncoding('UTF-8');
        $message->setFrom($this->from['email'], $this->from['name']); // konto do wysyłania maili z serwisu
        $message->addTo($this->to, "Administrator"); // osoba obsługująca zgłoszenia
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
