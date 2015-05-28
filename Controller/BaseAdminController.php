<?php

namespace Sunsetlabs\EcommerceResourceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use JavierEguiluz\Bundle\EasyAdminBundle\Controller\AdminController as EasyAdminController;

class BaseAdminController extends EasyAdminController
{
    protected $controllers;

    public function __construct()
    {
        $this->controllers = array();
    }

    public function indexAction(Request $request)
    {
        $result = $this->initialize($request);

        // initialize() returns a Response object when an error occurs.
        // This allows to display a detailed error message.
        if ($result instanceof Response) {
            return $result;
        }

        $action = $request->query->get('action', 'list');

        // for now, the homepage redirects to the 'list' action and view of the first entity
        if (null === $request->query->get('entity')) {
            return $this->redirect($this->generateUrl('admin', array(
                'action' => $action,
                'entity' => $this->getNameOfTheFirstConfiguredEntity(),
                'view'   => $this->view,
            )));
        }

        $entity_name = $this->entity['name'];
        if (isset($this->controllers[$entity_name])) {
            $entity_admin = $this->get($this->controllers[$entity_name]);
        }else{
            $entity_admin = null;
        }

        $customMethod = $action.$this->entity['name'].'Action';
        $defaultMethod = $action.'Action';

        if (($entity_admin) and method_exists($entity_admin, $defaultMethod)){
            return $entity_admin->$defaultMethod($request);
        }
        if (method_exists($this, $customMethod)){
        	return $this->$customMethod();
        }else{
        	return $this->$defaultMethod();
        }
    }

    protected function ajaxEditAction()
    {
        if (!$entity = $this->em->getRepository($this->entity['class'])->find($this->request->query->get('id'))) {
            throw new \Exception('The entity does not exist.');
        }

        $propertyName = $this->request->query->get('property');
        $propertyMetadata = $this->entity['list']['fields'][$propertyName];

        if (!isset($this->entity['list']['fields'][$propertyName]) || 'toggle' != $propertyMetadata['dataType']) {
            throw new \Exception(sprintf('The "%s" property is not a switchable toggle.', $propertyName));
        }

        if (!$propertyMetadata['canBeSet']) {
            throw new \Exception(sprintf('It\'s not possible to toggle the value of the "%s" boolean property of the "%s" entity.', $propertyName, $this->entity['name']));
        }

        $newValue = ('true' === strtolower($this->request->query->get('newValue'))) ? true : false;
        if (null !== $setter = $propertyMetadata['setter']) {
            $entity->{$setter}($newValue);
        } else {
            $entity->{$propertyName} = $newValue;
        }

        $this->em->flush();

        return new Response((string) $newValue);
    }
}
