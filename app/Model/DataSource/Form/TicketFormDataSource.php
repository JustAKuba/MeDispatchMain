<?php
declare(strict_types=1);

namespace App\Model\DataSource\Form;

use App\Model\Repository\Table\TicketRepository;
use App\Types\DB\Tables\TDBTicket;
use App\Types\Form\TFormTicket;



class TicketFormDataSource
{
    public $TicketRepository;

    public function __construct(TicketRepository $TicketRepository, )
    {
        $this->TicketRepository = $TicketRepository;
    }

    public function getDefaultsEditTicket($ticketId): TFormTicket
    {
        $ticket = $this->TicketRepository->fetchById($ticketId);
        $values = new TFormTicket();

        if($ticket){
            $values->id = $ticket->id;
            $values->urgency = $ticket->urgency;
            $values->state = $ticket->state;
            $values->vehicle = $ticket->vehicle;
            $values->location_address = $ticket->location_address;
            $values->location_gps = $ticket->location_gps;
            $values->summary = $ticket->summary;
            $values->description = $ticket->description;
            $values->created_at = $ticket->created_at;
            $values->deleted_by = $ticket->deleted_by;
            $values->date_deleted = $ticket->date_deleted;
        }
        return $values;
    }

    public function save(TFormTicket $values): int {
        $ticket = new TDBTicket();
        $ticket->id = $values->id;
        $ticket->urgency = $values->urgency;
        $ticket->state = $values->state;
        $ticket->vehicle = $values->vehicle;
        $ticket->location_address = $values->location_address;
        $ticket->location_gps = $values->location_gps;
        $ticket->summary = $values->summary;
        $ticket->description = $values->description;
        $ticket->created_at = $values->created_at;
        $ticket->deleted_by = $values->deleted_by;
        $ticket->date_deleted = $values->date_deleted;
        $ticket->is_deleted = $values->is_deleted;
        return $this->TicketRepository->save($ticket);
    }


}