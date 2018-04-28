<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;


class MovieController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for movie
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'Movie', $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = [];
        }
        $parameters["order"] = "id";

        $movie = Movie::find($parameters);
        if (count($movie) == 0) {
            $this->flash->notice("The search did not find any movie");

            $this->dispatcher->forward([
                "controller" => "movie",
                "action" => "index"
            ]);

            return;
        }

        $paginator = new Paginator([
            'data' => $movie,
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
     * Edits a movie
     *
     * @param string $id
     */
    public function editAction($id)
    {
        if (!$this->request->isPost()) {

            $movie = Movie::findFirstByid($id);
            if (!$movie) {
                $this->flash->error("movie was not found");

                $this->dispatcher->forward([
                    'controller' => "movie",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->id = $movie->id;

            $this->tag->setDefault("id", $movie->id);
            $this->tag->setDefault("movietitle", $movie->movietitle);
            $this->tag->setDefault("movieyear", $movie->movieyear);
            $this->tag->setDefault("genre", $movie->genre);
            $this->tag->setDefault("Actors", $movie->Actors);
            $this->tag->setDefault("price", $movie->price);
            
        }
    }

    /**
     * Creates a new movie
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "movie",
                'action' => 'index'
            ]);

            return;
        }

        $movie = new Movie();
        $movie->movietitle = $this->request->getPost("movietitle");
        $movie->movieyear = $this->request->getPost("movieyear");
        $movie->genre = $this->request->getPost("genre");
        $movie->actors = $this->request->getPost("Actors");
        $movie->price = $this->request->getPost("price");
        

        if (!$movie->save()) {
            foreach ($movie->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "movie",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("movie was created successfully");

        $this->dispatcher->forward([
            'controller' => "movie",
            'action' => 'index'
        ]);
    }

    /**
     * Saves a movie edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "movie",
                'action' => 'index'
            ]);

            return;
        }

        $id = $this->request->getPost("id");
        $movie = Movie::findFirstByid($id);

        if (!$movie) {
            $this->flash->error("movie does not exist " . $id);

            $this->dispatcher->forward([
                'controller' => "movie",
                'action' => 'index'
            ]);

            return;
        }

        $movie->movietitle = $this->request->getPost("movietitle");
        $movie->movieyear = $this->request->getPost("movieyear");
        $movie->genre = $this->request->getPost("genre");
        $movie->actors = $this->request->getPost("Actors");
        $movie->price = $this->request->getPost("price");
        

        if (!$movie->save()) {

            foreach ($movie->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "movie",
                'action' => 'edit',
                'params' => [$movie->id]
            ]);

            return;
        }

        $this->flash->success("movie was updated successfully");

        $this->dispatcher->forward([
            'controller' => "movie",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a movie
     *
     * @param string $id
     */
    public function deleteAction($id)
    {
        $movie = Movie::findFirstByid($id);
        if (!$movie) {
            $this->flash->error("movie was not found");

            $this->dispatcher->forward([
                'controller' => "movie",
                'action' => 'index'
            ]);

            return;
        }

        if (!$movie->delete()) {

            foreach ($movie->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "movie",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("movie was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "movie",
            'action' => "index"
        ]);
    }

}
