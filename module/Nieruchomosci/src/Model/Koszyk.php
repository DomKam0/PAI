<?php

namespace Nieruchomosci\Model;

use Laminas\Paginator\Adapter\LaminasDb\DbSelect;
use Laminas\Db\Adapter as DbAdapter;
use Laminas\Session\SessionManager;
use Laminas\Paginator\Paginator;
use Laminas\Session\Container;
use Laminas\Db\Sql\Sql;

class Koszyk implements DbAdapter\AdapterAwareInterface
{
	use DbAdapter\AdapterAwareTrait;
	
	protected Container $sesja;
	
	public function __construct()
	{
		$this->sesja = new Container('koszyk');
		$this->sesja->liczba_ofert = $this->sesja->liczba_ofert ?: 0;
	}

    /**
     * Dodaje ofertdo koszyka.
     *
     * @param int $idOferty
     * @return int|null
     */
	public function dodaj(int $idOferty): ?int
	{
		$dbAdapter = $this->adapter;
		$session = new SessionManager();
		$sql = new Sql($dbAdapter);
		
		$select = $sql->select('koszyk');
        $select->where(['id_oferty' => $idOferty]);
		$select->where(['id_sesji' => $session->getId()]);
		$selectStr = $sql->buildSqlString($select);
        $result = $dbAdapter->query($selectStr, $dbAdapter::QUERY_MODE_EXECUTE);
		
		if($result->count() != 1){
			$insert = $sql->insert('koszyk');
			$insert->values([
				'id_oferty' => $idOferty,
				'id_sesji' => $session->getId()
			]);

		$selectStr = $sql->buildSqlString($insert);
        $result = $dbAdapter->query($selectStr, $dbAdapter::QUERY_MODE_EXECUTE);
		
		$count = $sql->select('koszyk');
		$count->where(['id_sesji' => $session->getId()]);
		$selectStr = $sql->buildSqlString($count);
		$count = $dbAdapter->query($selectStr, $dbAdapter::QUERY_MODE_EXECUTE);
		$this->sesja->liczba_ofert = $count->count();

		
		try {
			return $result->getGeneratedValue();
		} catch(\Exception $e) {return null;}
	}else {return null;}
	}

    /**
     * Zwraca liczbe ofert w koszyku.
     *
     * @return int
     */
	public function liczbaOfert(): int
	{
		$dbAdapter = $this->adapter;
		$session = new SessionManager();
		$sql = new Sql($dbAdapter);
        $count = $sql->select('koszyk');
		$count->where(['id_sesji' => $session->getId()]);
		$selectStr = $sql->buildSqlString($count);
		$count = $dbAdapter->query($selectStr, $dbAdapter::QUERY_MODE_EXECUTE);
		$this->sesja->liczba_ofert = $count->count();
		return $this->sesja->liczba_ofert;
	}

	public function pobierzWszystko(array $szukaj = []): Paginator
    {
        $dbAdapter = $this->adapter;
		$session = new SessionManager();
		$sql = new Sql($dbAdapter);
        $select = $sql->select('oferty');
		$select->join('koszyk', 'koszyk.id_oferty = oferty.id',[],$select::JOIN_INNER );

		$select->where(['koszyk.id_sesji' => $session->getId()]);

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

	public function usun(int $idOferty)
    {
        $dbAdapter = $this->adapter;
		$session = new SessionManager();
		$sql = new Sql($dbAdapter);
        $delete = $sql->delete('koszyk');
        $delete->where(['id_sesji' => $session->getId()]);
        $delete->where(['id_oferty' => $idOferty]);

        $selectStr = $sql->buildSqlString($delete);
		$result = $dbAdapter->query($selectStr, $dbAdapter::QUERY_MODE_EXECUTE);

        try {
            return $result->getGeneratedValue();
        } catch(\Exception $e) { return null;}
    }




}