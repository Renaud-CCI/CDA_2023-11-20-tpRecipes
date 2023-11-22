<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Http\Requests\NovaRequest;
use Halimtuhu\ArrayFiles\ArrayFiles;

class Recipe extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Recipe>
     */
    public static $model = \App\Models\Recipe::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),

            Text::make('Nom', 'name')->sortable(),

            Text::make('Ingrédients', function(){
                $ingredients = $this->ingredients;
                $ingredientsString = '';
                foreach ($ingredients as $key => $ingredient) {  
                    $ingredientsString .= $ingredient;         
                    if ($key != count($ingredients) - 1) {
                        $ingredientsString .=', ';
                    }
                }
                return $ingredientsString;
            }),

            Text::make('Préparation', 'preparationTime')->sortable(),

            Text::make('Cuisson', 'cookingTime')->sortable(),

            Number::make('Couverts', 'serves')->sortable(),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [];
    }
}
