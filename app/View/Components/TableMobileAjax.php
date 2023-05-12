<?php

namespace App\View\Components;

use Illuminate\View\Component;

class TableMobileAjax extends Component
{
    public $tableNumCols = 0;
    public $tableClass = '';
    public $tableColsNames = [];
    public $tableColsFields = [];
    public $tableColActions = 'yes';

    public function __construct($numCols = [], $class, $colsNames, $colsFields, $colActions)
    {
        $this->tableNumCols = $numCols;
        $this->tableClass = $class;
        $this->tableColsNames = $colsNames;
        $this->tableColsFields = $colsFields;
        $this->tableColActions = $colActions;
    }

    public function render()
    {
        return view('components.table-Mobile-ajax');
    }
}
