<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;


class BookingController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for booking
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'Booking', $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = [];
        }
        $parameters["order"] = "id";

        $booking = Booking::find($parameters);
        if (count($booking) == 0) {
            $this->flash->notice("The search did not find any booking");

            $this->dispatcher->forward([
                "controller" => "booking",
                "action" => "index"
            ]);

            return;
        }

        $paginator = new Paginator([
            'data' => $booking,
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
     * Edits a booking
     *
     * @param string $id
     */
    public function editAction($id)
    {
        if (!$this->request->isPost()) {

            $booking = Booking::findFirstByid($id);
            if (!$booking) {
                $this->flash->error("booking was not found");

                $this->dispatcher->forward([
                    'controller' => "booking",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->id = $booking->id;

            $this->tag->setDefault("id", $booking->id);
            $this->tag->setDefault("bookingdate", $booking->bookingdate);
            $this->tag->setDefault("starttime", $booking->starttime);
            $this->tag->setDefault("endtime", $booking->endtime);
            $this->tag->setDefault("customerid", $booking->customerid);
            $this->tag->setDefault("screenid", $booking->screenid);
            $this->tag->setDefault("price", $booking->price);
            
        }
    }

    /**
     * Creates a new booking
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "booking",
                'action' => 'index'
            ]);

            return;
        }

        $booking = new Booking();
        $booking->bookingdate = $this->request->getPost("bookingdate");
        $booking->starttime = $this->request->getPost("starttime");
        $booking->endtime = $this->request->getPost("endtime");
        $booking->customerid = $this->request->getPost("customerid");
        $booking->screenid = $this->request->getPost("screenid");
        $booking->price = $this->request->getPost("price");
        

        if (!$booking->save()) {
            foreach ($booking->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "booking",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("booking was created successfully");

        $this->dispatcher->forward([
            'controller' => "booking",
            'action' => 'index'
        ]);
    }

    /**
     * Saves a booking edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "booking",
                'action' => 'index'
            ]);

            return;
        }

        $id = $this->request->getPost("id");
        $booking = Booking::findFirstByid($id);

        if (!$booking) {
            $this->flash->error("booking does not exist " . $id);

            $this->dispatcher->forward([
                'controller' => "booking",
                'action' => 'index'
            ]);

            return;
        }

        $booking->bookingdate = $this->request->getPost("bookingdate");
        $booking->starttime = $this->request->getPost("starttime");
        $booking->endtime = $this->request->getPost("endtime");
        $booking->customerid = $this->request->getPost("customerid");
        $booking->screenid = $this->request->getPost("screenid");
        $booking->price = $this->request->getPost("price");
        

        if (!$booking->save()) {

            foreach ($booking->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "booking",
                'action' => 'edit',
                'params' => [$booking->id]
            ]);

            return;
        }

        $this->flash->success("booking was updated successfully");

        $this->dispatcher->forward([
            'controller' => "booking",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a booking
     *
     * @param string $id
     */
    public function deleteAction($id)
    {
        $booking = Booking::findFirstByid($id);
        if (!$booking) {
            $this->flash->error("booking was not found");

            $this->dispatcher->forward([
                'controller' => "booking",
                'action' => 'index'
            ]);

            return;
        }

        if (!$booking->delete()) {

            foreach ($booking->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "booking",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("booking was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "booking",
            'action' => "index"
        ]);
    }

}
