<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;


class TicketController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for ticket
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'Ticket', $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = [];
        }
        $parameters["order"] = "id";

        $ticket = Ticket::find($parameters);
        if (count($ticket) == 0) {
            $this->flash->notice("The search did not find any ticket");

            $this->dispatcher->forward([
                "controller" => "ticket",
                "action" => "index"
            ]);

            return;
        }

        $paginator = new Paginator([
            'data' => $ticket,
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
     * Edits a ticket
     *
     * @param string $id
     */
    public function editAction($id)
    {
        if (!$this->request->isPost()) {

            $ticket = Ticket::findFirstByid($id);
            if (!$ticket) {
                $this->flash->error("ticket was not found");

                $this->dispatcher->forward([
                    'controller' => "ticket",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->id = $ticket->getId();

            $this->tag->setDefault("id", $ticket->getId());
            $this->tag->setDefault("name", $ticket->getName());
            $this->tag->setDefault("description", $ticket->getDescription());
            $this->tag->setDefault("price", $ticket->getPrice());
            $this->tag->setDefault("image", $ticket->getImage());
            
        }
    }

    /**
     * Creates a new ticket
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "ticket",
                'action' => 'index'
            ]);

            return;
        }

        $ticket = new Ticket();
        $ticket->setname($this->request->getPost("name"));
        $ticket->setdescription($this->request->getPost("description"));
        $ticket->setprice($this->request->getPost("price"));
        $ticket->setimage($this->request->getPost("image"));
        

        if (!$ticket->save()) {
            foreach ($ticket->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "ticket",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("ticket was created successfully");

        $this->dispatcher->forward([
            'controller' => "ticket",
            'action' => 'index'
        ]);
    }

    /**
     * Saves a ticket edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "ticket",
                'action' => 'index'
            ]);

            return;
        }

        $id = $this->request->getPost("id");
        $ticket = Ticket::findFirstByid($id);

        if (!$ticket) {
            $this->flash->error("ticket does not exist " . $id);

            $this->dispatcher->forward([
                'controller' => "ticket",
                'action' => 'index'
            ]);

            return;
        }

        $ticket->setname($this->request->getPost("name"));
        $ticket->setdescription($this->request->getPost("description"));
        $ticket->setprice($this->request->getPost("price"));
        $ticket->setimage($this->request->getPost("image"));
        

        if (!$ticket->save()) {

            foreach ($ticket->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "ticket",
                'action' => 'edit',
                'params' => [$ticket->getId()]
            ]);

            return;
        }

        $this->flash->success("ticket was updated successfully");

        $this->dispatcher->forward([
            'controller' => "ticket",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a ticket
     *
     * @param string $id
     */
    public function deleteAction($id)
    {
        $ticket = Ticket::findFirstByid($id);
        if (!$ticket) {
            $this->flash->error("ticket was not found");

            $this->dispatcher->forward([
                'controller' => "ticket",
                'action' => 'index'
            ]);

            return;
        }

        if (!$ticket->delete()) {

            foreach ($ticket->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "ticket",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("ticket was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "ticket",
            'action' => "index"
        ]);
    }
	public function emptyCartAction()
	{
		$this->session->remove('cart');
	}
	public function displayGridAction()
	{
		if ($this->session->has('cart')) {
			$cart = $this->session->get('cart');
			$totalQty=0;
			foreach ($cart as $ticket => $qty) {
				$totalQty = $totalQty + $qty;
			}
			$this->view->totalItems=$totalQty;
		}
		else {
			$this->view->totalItems=0;
		}
		$this->view->tickets = ticket::find();
	}
	public function addItemAction()
	{
		$ticketid = $this->request->getPost('ticketid');
		if ($this->session->has('cart')) {
			$cart = $this->session->get('cart');
			if (isset($cart[$ticketid])) {
				$cart[$ticketid]=$cart[$ticketid]+1; //add one to product in cart
			}
			else {
				$cart[$ticketid]=1; //new product in cart
			}
		}
		else {
			$cart[$ticketid]=1; //new cart
		}
		$this->session->set('cart',$cart); // make the cart a session variable
	}
	public function checkOutAction()
	{
		if ($this->session->has('cart')) {
			$cart = $this->session->get('cart');
			$lineitems = array();
			foreach ($cart as $ticketid => $qty) {
				$lineitem['ticket'] = Ticket::findFirstByid($ticketid);
				$lineitem['qty'] = $qty;
				$lineitems[] = $lineitem;
			}
			$this->view->lineitems = $lineitems;
		}
		else {
			$this->flash->error("There are no items in your cart");
			$this->dispatcher->forward(['controller' => "ticket",'action' => 'displayGrid']);
		}
	}
	public function placeOrderAction()
	{
		$thisOrder = new Scorder();
		$thisOrder->setOrderDate((new DateTime())->format("Y-m-d H:i:s"));
		$thisOrder->save();
		$orderID = $thisOrder->getId();
		
		$ticketids = $this->request->getPost("ticketid");
		$quantities = $this->request->getPost("quantity");
		for($i=0;$i<sizeof($productids);$i++) {
			$thisOrderDetail = new OrderDetail();
			$thisOrderDetail->setOrderid($orderID);
			$thisOrderDetail->setTicketid($ticketids[$i]);
			$thisOrderDetail->setQuantity($quantities[$i]);
			$thisOrderDetail->save();
		}
		$this->session->remove('cart');
		$this->flash->success("The Order has been placed");
		$this->dispatcher->forward(["controller" => "ticket", "action" => "displayGrid"]);
	}
}
