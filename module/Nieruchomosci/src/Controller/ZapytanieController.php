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
            $wynik = $this->zapytanie->wyslij($daneOferty, $this->params()->fromPost('tresc'));

            if ($wynik) {
                $this->getResponse()->setContent('ok');
            }
        }

        return $this->getResponse();
    }
}
