<?php

namespace Nieruchomosci\Model;

use Laminas\Db\Adapter as DbAdapter;
use Laminas\Db\Sql\Sql;
use Laminas\Paginator\Adapter\LaminasDb\DbSelect;
use Laminas\Paginator\Paginator;
use Laminas\View\Model\ViewModel;
use Laminas\View\Renderer\PhpRenderer;
use Mpdf\Mpdf;

class Oferta implements DbAdapter\AdapterAwareInterface
{
    use DbAdapter\AdapterAwareTrait;

    public function __construct(public PhpRenderer $phpRenderer)
    {
    }

    /**
     * Pobiera obiekt Paginator dla przekazanych parametrów.
     *
     * @param array $szukaj
     * @return \Laminas\Paginator\Paginator
     */
    public function pobierzWszystko(array $szukaj = []): Paginator
    {
        $dbAdapter = $this->adapter;

        $sql = new Sql($dbAdapter);
        $select = $sql->select('oferty');

        if (!empty($szukaj['typ_oferty'])) {
            $select->where(['typ_oferty' => $szukaj['typ_oferty']]);
        }
        if (!empty($szukaj['typ_nieruchomosci'])) {
            $select->where(['typ_nieruchomosci' => $szukaj['typ_nieruchomosci']]);
        }
        if (!empty($szukaj['numer'])) {
            $select->where(['numer' => $szukaj['numer']]);
        }
        if (!empty($szukaj['powierzchnia'])) {
            $select->where(['powierzchnia' => $szukaj['powierzchnia']]);
        }
        if (!empty($szukaj['cena'])) {
            $select->where(['cena' => $szukaj['cena']]);
        }

        $paginatorAdapter = new DbSelect($select, $dbAdapter);

        return new Paginator($paginatorAdapter);
    }

    /**
     * Pobiera dane jednej oferty.
     *
     * @param int $id
     * @return array
     */
    public function pobierz(int $id)
    {
        $dbAdapter = $this->adapter;

        $sql = new Sql($dbAdapter);
        $select = $sql->select('oferty');
        $select->where(['id' => $id]);

        $selectString = $sql->buildSqlString($select);
        $wynik = $dbAdapter->query($selectString, $dbAdapter::QUERY_MODE_EXECUTE);

        return $wynik->count() ? $wynik->current() : [];
    }

    /**
     * Generuje PDF z danymi oferty.
     *
     * @param $oferta
     * @throws \Mpdf\MpdfException
     */
    public function drukuj($oferta): void
    {
        $vm = new ViewModel(['oferta' => $oferta]);
        $vm->setTemplate('nieruchomosci/oferty/drukuj');
        $html = $this->phpRenderer->render($vm);

        $mpdf = new Mpdf(['tempDir' => getcwd() . '/data/temp']);
        $mpdf->WriteHTML($html);
        $mpdf->Output('oferta.pdf', 'D');
    }

    public function DrukPDFOferta($oferta)
    {
        $vm = new ViewModel(['oferta' => $oferta]);
        $vm->setTemplate('nieruchomosci/oferty/drukuj');
        $strona = $this->phpRenderer->render($vm);

        $mpdf = new Mpdf();
        $mpdf->WriteHTML($strona);

        return $mpdf->Output('oferta.pdf', \Mpdf\Output\Destination::STRING_RETURN);
    }

    public function service($idOferty, $tresc, $telefon, $nadawca): void
    {
        $dbAdapter = $this->adapter;
		$session = new SessionManager();
		$sql = new Sql($dbAdapter);
        
        $ins = $sql->insert('test');
		$ins->values([
			'id_klienta' => $session->getId(),
            'id_oferty' => $idOferty,
            'telefon' => $telefon,
            'tresc' => $tresc,
            'nadawca' => $nadawca]);
            
        $selectStr = $sql->buildSqlString($ins);
		$wynik = $dbAdapter->query($selectStr, $dbAdapter::QUERY_MODE_EXECUTE);
    }
}
