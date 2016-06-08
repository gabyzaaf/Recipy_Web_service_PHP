<?php

require_once 'appKernel.php';

$Article = new Recette();
/**
 * PUT  :    Add
 * GET  :    Find
 * POST :    update
 * DELETE:  remove
 */
switch ($request->request->get('mode')) {
    case 'POST':
        update($Article);
        break;
    default:
        return -1;
}

function update(Object $Object) : bool
{
    
}