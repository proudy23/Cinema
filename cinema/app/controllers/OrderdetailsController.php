<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;


class OrderdetailsController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for orderdetails
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'Orderdetails', $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = [];
        }
        $parameters["order"] = "id";

        $orderdetails = Orderdetails::find($parameters);
        if (count($orderdetails) == 0) {
            $this->flash->notice("The search did not find any orderdetails");

            $this->dispatcher->forward([
                "controller" => "orderdetails",
                "action" => "index"
            ]);

            return;
        }

        $paginator = new Paginator([
            'data' => $orderdetails,
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
     * Edits a orderdetail
     *
     * @param string $id
     */
    public function editAction($id)
    {
        if (!$this->request->isPost()) {

            $orderdetail = Orderdetails::findFirstByid($id);
            if (!$orderdetail) {
                $this->flash->error("orderdetail was not found");

                $this->dispatcher->forward([
                    'controller' => "orderdetails",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->id = $orderdetail->getId();

            $this->tag->setDefault("id", $orderdetail->getId());
            $this->tag->setDefault("productid", $orderdetail->getProductid());
            $this->tag->setDefault("orderid", $orderdetail->getOrderid());
            $this->tag->setDefault("quantity", $orderdetail->getQuantity());
            $this->tag->setDefault("subtotal", $orderdetail->getSubtotal());
            
        }
    }

    /**
     * Creates a new orderdetail
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "orderdetails",
                'action' => 'index'
            ]);

            return;
        }

        $orderdetail = new Orderdetails();
        $orderdetail->setproductid($this->request->getPost("productid"));
        $orderdetail->setorderid($this->request->getPost("orderid"));
        $orderdetail->setquantity($this->request->getPost("quantity"));
        $orderdetail->setsubtotal($this->request->getPost("subtotal"));
        

        if (!$orderdetail->save()) {
            foreach ($orderdetail->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "orderdetails",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("orderdetail was created successfully");

        $this->dispatcher->forward([
            'controller' => "orderdetails",
            'action' => 'index'
        ]);
    }

    /**
     * Saves a orderdetail edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "orderdetails",
                'action' => 'index'
            ]);

            return;
        }

        $id = $this->request->getPost("id");
        $orderdetail = Orderdetails::findFirstByid($id);

        if (!$orderdetail) {
            $this->flash->error("orderdetail does not exist " . $id);

            $this->dispatcher->forward([
                'controller' => "orderdetails",
                'action' => 'index'
            ]);

            return;
        }

        $orderdetail->setproductid($this->request->getPost("productid"));
        $orderdetail->setorderid($this->request->getPost("orderid"));
        $orderdetail->setquantity($this->request->getPost("quantity"));
        $orderdetail->setsubtotal($this->request->getPost("subtotal"));
        

        if (!$orderdetail->save()) {

            foreach ($orderdetail->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "orderdetails",
                'action' => 'edit',
                'params' => [$orderdetail->getId()]
            ]);

            return;
        }

        $this->flash->success("orderdetail was updated successfully");

        $this->dispatcher->forward([
            'controller' => "orderdetails",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a orderdetail
     *
     * @param string $id
     */
    public function deleteAction($id)
    {
        $orderdetail = Orderdetails::findFirstByid($id);
        if (!$orderdetail) {
            $this->flash->error("orderdetail was not found");

            $this->dispatcher->forward([
                'controller' => "orderdetails",
                'action' => 'index'
            ]);

            return;
        }

        if (!$orderdetail->delete()) {

            foreach ($orderdetail->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "orderdetails",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("orderdetail was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "orderdetails",
            'action' => "index"
        ]);
    }

}
