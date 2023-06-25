<?php

namespace App\Database\Models\Contract;

interface Crud
{
     function read();
     function create();
     function update();
     function delete();
}