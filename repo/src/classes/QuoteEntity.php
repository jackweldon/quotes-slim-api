<?php

class QuoteEntity implements JsonSerializable
{
    protected $Id;
    protected $Author;
    protected $Quote;

    /**
     * Accept an array of data matching properties of this class
     * and create the class
     *
     * @param array $data The data to use to create
     */
    public function __construct(array $data) {
        // no Id if we're creating
        if(isset($data['Id'])) {
            $this->Id = $data['Id'];
        }

        $this->Id = $data['Id'];
        $this->Quote = $data['Quote'];
        $this->Author = $data['Author'];
    }

    public function getId() {
        return $this->Id;
    }

    public function getQuote() {
        return $this->Quote;
    }

    public function getAuthor() {
        return $this->Author;
    }
	  public function jsonSerialize() {
        return array(
            'id' => $this->getId(),
            'quote' => $this->getQuote(),
            'author' => $this->getAuthor()
        );
    }
}