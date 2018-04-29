<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;


class ScorderController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for scorder
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'Scorder', $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = [];
        }
        $parameters["order"] = "id";

        $scorder = Scorder::find($parameters);
        if (count($scorder) == 0) {
            $this->flash->notice("The search did not find any scorder");

            $this->dispatcher->forward([
                "controller" => "scorder",
                "action" => "index"
            ]);

            return;
        }

        $paginator = new Paginator([
            'data' => $scorder,
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
     * Edits a scorder
     *
     * @param string $id
     */
    public function editAction($id)
    {
        if (!$this->request->isPost()) {

            $scorder = Scorder::findFirstByid($id);
            if (!$scorder) {
                $this->flash->error("scorder was not found");

                $this->dispatcher->forward([
                    'controller' => "scorder",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->id = $scorder->getId();

            $this->tag->setDefault("id", $scorder->getId());
            $this->tag->setDefault("orderDate", $scorder->getOrderdate());
            $this->tag->setDefault("deliveryCity", $scorder->getDeliverycity());
            $this->tag->setDefault("deliveryCounty", $scorder->getDeliverycounty());
            
        }
    }

    /**
     * Creates a new scorder
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "scorder",
                'action' => 'index'
            ]);

            return;
        }

        $scorder = new Scorder();
        $scorder->setorderDate($this->request->getPost("orderDate"));
        $scorder->setdeliveryCity($this->request->getPost("deliveryCity"));
        $scorder->setdeliveryCounty($this->request->getPost("deliveryCounty"));
        

        if (!$scorder->save()) {
            foreach ($scorder->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "scorder",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("scorder was created successfully");

        $this->dispatcher->forward([
            'controller' => "scorder",
            'action' => 'index'
        ]);
    }

    /**
     * Saves a scorder edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "scorder",
                'action' => 'index'
            ]);

            return;
        }

        $id = $this->request->getPost("id");
        $scorder = Scorder::findFirstByid($id);

        if (!$scorder) {
            $this->flash->error("scorder does not exist " . $id);

            $this->dispatcher->forward([
                'controller' => "scorder",
                'action' => 'index'
            ]);

            return;
        }

        $scorder->setorderDate($this->request->getPost("orderDate"));
        $scorder->setdeliveryCity($this->request->getPost("deliveryCity"));
        $scorder->setdeliveryCounty($this->request->getPost("deliveryCounty"));
        

        if (!$scorder->save()) {

            foreach ($scorder->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "scorder",
                'action' => 'edit',
                'params' => [$scorder->getId()]
            ]);

            return;
        }

        $this->flash->success("scorder was updated successfully");

        $this->dispatcher->forward([
            'controller' => "scorder",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a scorder
     *
     * @param string $id
     */
    public function deleteAction($id)
    {
        $scorder = Scorder::findFirstByid($id);
        if (!$scorder) {
            $this->flash->error("scorder was not found");

            $this->dispatcher->forward([
                'controller' => "scorder",
                'action' => 'index'
            ]);

            return;
        }

        if (!$scorder->delete()) {

            foreach ($scorder->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "scorder",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("scorder was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "scorder",
            'action' => "index"
        ]);
    }

}
