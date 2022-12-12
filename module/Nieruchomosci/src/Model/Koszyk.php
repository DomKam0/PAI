<?php

namespace Nieruchomosci\Model;

use Laminas\Db\Adapter as DbAdapter;
use Laminas\Db\Sql\Sql;
use Laminas\Session\Container;
use Laminas\Session\SessionManager;

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
        $insert = $sql->insert('koszyk');
        $insert->values([
            'id_oferty' => $idOferty,
            'id_sesji' => $session->getId(),
        ]);

        $selectString = $sql->buildSqlString($insert);
        $wynik = $dbAdapter->query($selectString, $dbAdapter::QUERY_MODE_EXECUTE);

        $this->sesja->liczba_ofert++;

        try {
            return $wynik->getGeneratedValue();
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Zwraca liczbe ofert w koszyku.
     *
     * @return int
     */
    public function liczbaOfert(): int
    {
        return $this->sesja->liczba_ofert;
    }
}