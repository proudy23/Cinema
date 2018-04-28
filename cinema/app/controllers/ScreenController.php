<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;


class ScreenController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for screen
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'Screen', $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = [];
        }
        $parameters["order"] = "id";

        $screen = Screen::find($parameters);
        if (count($screen) == 0) {
            $this->flash->notice("The search did not find any screen");

            $this->dispatcher->forward([
                "controller" => "screen",
                "action" => "index"
            ]);

            return;
        }

        $paginator = new Paginator([
            'data' => $screen,
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
     * Edits a screen
     *
     * @param string $id
     */
    public function editAction($id)
    {
        if (!$this->request->isPost()) {

            $screen = Screen::findFirstByid($id);
            if (!$screen) {
                $this->flash->error("screen was not found");

                $this->dispatcher->forward([
                    'controller' => "screen",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->id = $screen->id;

            $this->tag->setDefault("id", $screen->id);
            $this->tag->setDefault("area", $screen->area);
            $this->tag->setDefault("floor", $screen->floor);
            $this->tag->setDefault("recliner", $screen->recliner);
            
        }
    }

    /**
     * Creates a new screen
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "screen",
                'action' => 'index'
            ]);

            return;
        }

        $screen = new Screen();
        $screen->area = $this->request->getPost("area");
        $screen->floor = $this->request->getPost("floor");
        $screen->recliner = $this->request->getPost("recliner");
        

        if (!$screen->save()) {
            foreach ($screen->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "screen",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("screen was created successfully");

        $this->dispatcher->forward([
            'controller' => "screen",
            'action' => 'index'
        ]);
    }

    /**
     * Saves a screen edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "screen",
                'action' => 'index'
            ]);

            return;
        }

        $id = $this->request->getPost("id");
        $screen = Screen::findFirstByid($id);

        if (!$screen) {
            $this->flash->error("screen does not exist " . $id);

            $this->dispatcher->forward([
                'controller' => "screen",
                'action' => 'index'
            ]);

            return;
        }

        $screen->area = $this->request->getPost("area");
        $screen->floor = $this->request->getPost("floor");
        $screen->recliner = $this->request->getPost("recliner");
        

        if (!$screen->save()) {

            foreach ($screen->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "screen",
                'action' => 'edit',
                'params' => [$screen->id]
            ]);

            return;
        }

        $this->flash->success("screen was updated successfully");

        $this->dispatcher->forward([
            'controller' => "screen",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a screen
     *
     * @param string $id
     */
    public function deleteAction($id)
    {
        $screen = Screen::findFirstByid($id);
        if (!$screen) {
            $this->flash->error("screen was not found");

            $this->dispatcher->forward([
                'controller' => "screen",
                'action' => 'index'
            ]);

            return;
        }

        if (!$screen->delete()) {

            foreach ($screen->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "screen",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("screen was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "screen",
            'action' => "index"
        ]);
    }

}
