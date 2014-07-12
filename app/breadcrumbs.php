<?php

// INICIO
    Breadcrumbs::register('admin', function($breadcrumbs) {
        $breadcrumbs->push('Inicio', route('admin'));
    });


    // Modulo ESTADISTICAS
        Breadcrumbs::register('estadisticas', function($breadcrumbs) {
            $breadcrumbs->parent('admin');
            $breadcrumbs->push('Estadisticas', route('estadisticas'));
        });

        Breadcrumbs::register('get admin/estadisticas', function($breadcrumbs) {
            $breadcrumbs->parent('admin');
            $breadcrumbs->push('Estadisticas', route('estadisticas'));
        });
        
        // Estadisticas/Page
            Breadcrumbs::register('estadisticas/page', function($breadcrumbs, $page) {
                $breadcrumbs->parent('estadisticas');
                $breadcrumbs->push($page, route('estadisticas/'.$page));
            });

    // Modulo IMPORT
        Breadcrumbs::register('import', function($breadcrumbs) {
            $breadcrumbs->parent('admin');
            $breadcrumbs->push('Import', route('import'));
        });

        Breadcrumbs::register('get admin/import', function($breadcrumbs) {
            $breadcrumbs->parent('admin');
            $breadcrumbs->push('Import', route('import'));
        });

        Breadcrumbs::register('admin.import.resultado.index', function($breadcrumbs) {
            $breadcrumbs->parent('import');
            $breadcrumbs->push('Resultado', route('admin.import.resultado.index'));
        });

        Breadcrumbs::register('admin.import.resultado.show', function($breadcrumbs, $id) {
            $breadcrumbs->parent('admin.import.resultado.index');
            $breadcrumbs->push($id, route('admin.import.resultado.show', $id));
        });

        // Import/Page

            Breadcrumbs::register('import/archivo', function($breadcrumbs) {
                $breadcrumbs->parent('import');
                $breadcrumbs->push('Archivo', route('import/archivo'));
            });

    // Modulo Administracion datos
    	Breadcrumbs::register('model', function($breadcrumbs, $modelName) {
            $breadcrumbs->parent('admin');
            $breadcrumbs->push(ucfirst($modelName), route('admin.'.$modelName.'.index'));
        });

        Breadcrumbs::register('model/action', function($breadcrumbs, $modelName, $action, $nameAction) {
            $breadcrumbs->parent('model', $modelName);
            $breadcrumbs->push($nameAction, route('admin.'.$modelName.'.'.$action));
        });

        Breadcrumbs::register('model/action/id', function($breadcrumbs, $modelName, $action, $modelId) {
            $breadcrumbs->parent('model', $modelName);
            $breadcrumbs->push($modelId, route('admin.'.$modelName.'.'.$action, $modelId));
        });
