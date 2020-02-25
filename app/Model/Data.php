<?php

namespace App\Model;

class Data
{
    //
    public $products;
    public $categories;
    public $blogs;

    /**
     * @return mixed
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * @param mixed $products
     */
    public function setProducts($products): void
    {
        $this->products = $products;
    }

    /**
     * @return mixed
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * @param mixed $categories
     */
    public function setCategories($categories): void
    {
        $this->categories = $categories;
    }

    /**
     * @return mixed
     */
    public function getBlogs()
    {
        return $this->blogs;
    }

    /**
     * @param mixed $blogs
     */
    public function setBlogs($blogs): void
    {
        $this->blogs = $blogs;
    }
}
