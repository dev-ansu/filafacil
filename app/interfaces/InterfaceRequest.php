<?php

namespace app\interfaces;

interface InterfaceRequest{

    public function __construct();

    /**
     * @return array
     */
    public function authorize():bool;

    /**
     * @return array
     */
    public function rules():array;

    /**
     * @return array
     */
    public function messages():array;
}
