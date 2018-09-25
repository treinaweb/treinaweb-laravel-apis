<?php

namespace App\Services;

use Illuminate\Contracts\Support\Arrayable;

class LinksGenerator implements Arrayable
{
    protected $links = [];

    protected function add(string $type, string $rel, string $uri) : void
    {
        $this->links[] = [
            'type' => $type,
            'rel' => $rel,
            'uri' => $uri,
        ];
    }

    public function addGet(string $rel, string $uri) : self
    {
        $this->add('GET', $rel, $uri);

        return $this;
    }

    public function addPost(string $rel, string $uri) : self
    {
        $this->add('POST', $rel, $uri);

        return $this;
    }

    public function addPut(string $rel, string $uri) : self
    {
        $this->add('PUT', $rel, $uri);

        return $this;
    }

    public function addDelete(string $rel, string $uri) : self
    {
        $this->add('DELETE', $rel, $uri);

        return $this;
    }

    public function toArray() : array
    {
        return $this->links;
    }    

}