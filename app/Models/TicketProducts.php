<?php

namespace App\Models;

class TicketProducts extends TicketQuery
{
  protected $_data = [];

  public function __construct()
  {
    $this->_getTicketProducts();
  }

  protected function _getTicketProducts()
  {
    $url = 'https://tickets.ifcat.org/api/v1/organizers/ifcat/events/mch2022/items/';
    $_data = $this->_getJsonDataAll($url);

    foreach ($_data as $product)
    {
      $this->_data[$product['id']] = $product;
    }
  }

  public function __serialize(): array
  {
    return $this->_data;
  }

  public function __unserialize(array $data): void
  {
    $this->_data = $data;
  }

  public function __get(string $name): mixed
  {
    if (array_key_exists($name, $this->_data)) {
      return $this->_data[$name];
    }

    $trace = debug_backtrace();
    trigger_error(
        'Undefined property via __get(): ' . $name .
        ' in ' . $trace[0]['file'] .
        ' on line ' . $trace[0]['line'],
        E_USER_NOTICE);
    return null;
  }

  public function __isset(string $name): bool
  {
    return isset($this->_data[$name]);
  }

  public function __toArray(): Array
  {
    return $this->_data;
  }
}
