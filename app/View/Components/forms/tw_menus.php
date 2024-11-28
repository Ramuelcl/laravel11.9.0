<?php

namespace App\View\Components\forms;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class tw_menus extends Component {
  public $menus;
 
    public function mount($id=10000){
      dd($id,'mount');
    }
    public function __construct($id=10000)
    {
      dd($id,'__construct');
      $this->menus = [
    'Dashboard' => [
        'id' => 1,
        'route' => 'dashboard',
        'icon' => 'dashboard-icon',
        'active' => request()->routeIs('dashboard'),
    ],
    'Calendar' => [
        'id' => 2,
        'route' => 'calendar',
        'icon' => 'calendar-icon',
        'active' => request()->routeIs('calendar'),
    ],
    'Proyectos' => [
        'id' => 3,
        'route' => 'projects',
        'icon' => 'project-icon',
        'submenu' => [
            'Edit' => [
                'route' => 'projects.edit',
                'icon' => 'edit-icon',
                'active' => request()->routeIs('projects.edit'),
            ],
            'Update' => [
                'route' => 'projects.update',
                'icon' => 'update-icon',
                'active' => request()->routeIs('projects.update'),
            ],
        ],
        'active' => request()->routeIs('projects*'),
    ],
];
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.forms.tw_menus', [
            'menus' => $this->menus,
        ]);
    }
}
