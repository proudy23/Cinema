<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;


class CustomerController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for customer
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'Customer', $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = [];
        }
        $parameters["order"] = "id";

        $customer = Customer::find($parameters);
        if (count($customer) == 0) {
            $this->flash->notice("The search did not find any customer");

            $this->dispatcher->forward([
                "controller" => "customer",
                "action" => "index"
            ]);

            return;
        }

        $paginator = new Paginator([
            'data' => $customer,
            'limit'=> 10,
            'page' => $numberPage
        ]);

        $this->view->page = $paginator->getPaginate();
    }

    /**
     * Displays the creation form
     */
    public function newAction()
    {

    }

    /**
     * Edits a customer
     *
     * @param string $id
     */
    public function editAction($id)
    {
        if (!$this->request->isPost()) {

            $customer = Customer::findFirstByid($id);
            if (!$customer) {
                $this->flash->error("customer was not found");

                $this->dispatcher->forward([
                    'controller' => "customer",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->id = $customer->id;

            $this->tag->setDefault("id", $customer->id);
            $this->tag->setDefault("firstname", $customer->firstname);
            $this->tag->setDefault("surname", $customer->surname);
            $this->tag->setDefault("membertype", $customer->membertype);
            $this->tag->setDefault("dateofbirth", $customer->dateofbirth);
            $this->tag->setDefault("address", $customer->address);
            
        }
    }

    /**
     * Creates a new customer
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "customer",
                'action' => 'index'
            ]);

            return;
        }

        $customer = new Customer();
        $customer->firstname = $this->request->getPost("firstname");
        $customer->surname = $this->request->getPost("surname");
        $customer->membertype = $this->request->getPost("membertype");
        $customer->dateofbirth = $this->request->getPost("dateofbirth");
        $customer->address = $this->request->getPost("address");
        

        if (!$customer->save()) {
            foreach ($customer->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "customer",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("customer was created successfully");

        $this->dispatcher->forward([
            'controller' => "customer",
            'action' => 'index'
        ]);
    }

    /**
     * Saves a customer edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "customer",
                'action' => 'index'
            ]);

            return;
        }

        $id = $this->request->getPost("id");
        $customer = Customer::findFirstByid($id);

        if (!$customer) {
            $this->flash->error("customer does not exist " . $id);

            $this->dispatcher->forward([
                'controller' => "customer",
                'action' => 'index'
            ]);

            return;
        }

        $customer->firstname = $this->request->getPost("firstname");
        $customer->surname = $this->request->getPost("surname");
        $customer->membertype = $this->request->getPost("membertype");
        $customer->dateofbirth = $this->request->getPost("dateofbirth");
        $customer->address = $this->request->getPost("address");
        

        if (!$customer->save()) {

            foreach ($customer->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "customer",
                'action' => 'edit',
                'params' => [$customer->id]
            ]);

            return;
        }

        $this->flash->success("customer was updated successfully");

        $this->dispatcher->forward([
            'controller' => "customer",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a customer
     *
     * @param string $id
     */
    public function deleteAction($id)
    {
        $customer = Customer::findFirstByid($id);
        if (!$customer) {
            $this->flash->error("customer was not found");

            $this->dispatcher->forward([
                'controller' => "customer",
                'action' => 'index'
            ]);

            return;
        }

        if (!$customer->delete()) {

            foreach ($customer->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "customer",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("customer was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "customer",
            'action' => "index"
        ]);
    }

}
