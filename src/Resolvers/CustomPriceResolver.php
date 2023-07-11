<?php

namespace Drupal\custom_price_rol_professional\Resolvers;

use Drupal\commerce\Context;
use Drupal\commerce\PurchasableEntityInterface;
use Drupal\commerce_order\Entity\OrderInterface;
use Drupal\commerce_price\Price;
use Drupal\commerce_price\Resolver\PriceResolverInterface;
use Drupal\user\Entity\User;


/**
 * Returns a Price for the Professional Users.
 */
class CustomPriceResolver implements PriceResolverInterface{

  public $iva;

  /**
   * {@inheritdoc}
   */

  public function resolve(PurchasableEntityInterface $entity, $quantity, Context $context)
  {
    $this->process();
    $current_user_id = \Drupal::currentUser()->id();
    $account = User::load($current_user_id);
    $rol_profesional = $account->hasRole('profesional');
    $rol_cliente_exento_de_iva = $account->hasRole('cliente_exento_de_iva');

    if ($rol_cliente_exento_de_iva && $rol_profesional) {
      $precioProfesional = $entity->get('field_precio_profesionales')->number;
      $precio = $precioProfesional/1.21;
      $precioCurrency = "EUR";
      return new Price($precio, $precioCurrency);
    }else if ($rol_cliente_exento_de_iva){
      $precioOriginal = $entity->getPrice()->getNumber();
      $precio = $precioOriginal/1.21;
      $precioCurrency = "EUR";
      return new Price($precio, $precioCurrency);
    }

    if (($rol_profesional) && ($entity->get('field_precio_profesionales')->number != 0)) {
      $precio = $entity->get('field_precio_profesionales')->number;
      $precioCurrency = $entity->getPrice()->getCurrencyCode();
      return new Price($precio, $precioCurrency);
    } else {
      $entity->set('field_precio_profesionales', null);
    }
  }
  public function process(){
    $parameter = \Drupal::routeMatch()->getParameter('commerce_order');

    $current_user_id = \Drupal::currentUser()->id();
    $account = User::load($current_user_id);
    $rol_profesional = $account->hasRole('profesional');
  }
  public function setIva($value) {
    $this->iva = $value;
  }
}
