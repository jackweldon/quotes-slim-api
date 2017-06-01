<?php 
class QuoteMapper extends Mapper
{
    public function getQuotes() {
        $sql = "SELECT Id, Quote, Author
            from Quotes ";
        $stmt = $this->db->query($sql);

        $results = [];
        while($row = $stmt->fetch()) {
            $results[] = new QuoteEntity($row);
        }
        return $results;
    }

    /**
     * Get one ticket by its ID
     *
     * @param int $ticket_id The ID of the ticket
     * @return TicketEntity  The ticket
     */
    public function getQuotesByType($type) {
			$sql = "SELECT * FROM Quotes WHERE QuoteType = :type ";       
        $stmt = $this->db->prepare($sql);
        $stmt->execute(["type" => $type]);

        $results = [];
        while($row = $stmt->fetch()) {
            $results[] = new QuoteEntity($row);
        }
        return $results;

    }

    public function save(QuoteEntity $ticket) {
       
    }
}
