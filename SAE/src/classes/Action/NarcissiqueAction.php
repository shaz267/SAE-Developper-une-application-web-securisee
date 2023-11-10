<?php

namespace touiteur\classes\Action;

class NarcissiqueAction extends Action
{

    public function execute(): string
    {



        Action::renderTouites($touites, '');
    }
}