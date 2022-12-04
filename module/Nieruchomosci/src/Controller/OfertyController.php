<?php

namespace Nieruchomosci\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Nieruchomosci\Model\Oferta;
use Nieruchomosci\Model\Koszyk;
use Nieruchomosci\Form;


class OfertyController extends AbstractActionController
{
    /**
     * OfertyController constructor.
     *
     * @param Oferta $oferta
     */
    public function __construct(public Oferta $oferta)
    {
    }

    public function listaAction()
    {
        $parametry = $this->params()->fromQuery();
        $strona = $parametry['strona'] ?? 1;

        // pobierz dane ofert
        $paginator = $this->oferta->pobierzWszystko($parametry);
        $paginator->setItemCountPerPage(10)->setCurrentPageNumber($strona);

        // zbuduj formularz wyszukiwania
        $form = new Form\OfertaSzukajForm();
        $form->populateValues($parametry);

        return new ViewModel([
            'form' => $form,
            'oferty' => $paginator,
            'parametry' => $parametry,
        ]);
    }

    public function szczegolyAction()
    {
        $daneOferty = $this->oferta->pobierz($this->params('id'));
        $form = new Form\OfertaSzukajForm();
        $form->populateValues($daneOferty);

        return ['oferta' => $daneOferty,
                'form' => $form, ];
    }

    public function drukujAction(){
    {
        $oferta = $this->oferta->pobierz($this->params('id'));
        if ($oferta) {
            $this->oferta->drukuj($oferta);
        }
        return $this->getResponse();
    }
}

    public function drukujKoszykAction()
    {
        $oferty = $this->oferta->pobierzOfertyKoszyk();
        if($oferty){
            $this->oferta->drukujKoszyk($oferty);
        }
        return $this->getResponse();
    }

}