<?php

namespace Nieruchomosci\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Nieruchomosci\Model\Oferta;
use Nieruchomosci\Model\Zapytanie;

class ZapytanieController extends AbstractActionController
{
    /**
     * ZapytanieController constructor.
     *
     * @param Oferta    $oferta
     * @param Zapytanie $zapytanie
     */
    public function __construct(public Oferta $oferta, public Zapytanie $zapytanie)
    {
    }

    public function wyslijAction()
    {
        $id = $this->params('id');

        if ($this->getRequest()->isPost() && $id) {
            $daneOferty = $this->oferta->pobierz($id);
            $plikOferta = $this->oferta->drukPDFOferta($daneOferty);
            $wynik = $this->zapytanie->wyslij($daneOferty,
                                             $this->params()->fromPost('tresc'),
                                             $this->params()->fromPost('email_odbiorca'),
                                             $this->params()->fromPost('email_nadawca'),
                                             $this->params()->fromPost('telefon'),
                                             $plikOferta);

            if ($wynik) {
                $this->oferta->service($id,
                                         $this->params()->fromPost('tresc'), 
                                         $this->params()->fromPost('email_nadawca'), 
                                         $this->params()->fromPost('telefon'));
                $this->getResponse()->setContent('ok');
            }
        }

        return $this->getResponse();
    }
}
