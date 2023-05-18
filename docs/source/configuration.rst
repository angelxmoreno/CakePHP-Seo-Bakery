Configuration
=============

After installation, all you need to get started is to let the plugin know which model you want to track. The plugin will
automatically attach the `MetaDataBehavior` to the models mentioned in the configuration. The configuration also
determines the controllers to automatically attach the `MetaDataComponent` to.

Adding Models
_____________
Many assumptions are made by the plugin in favor of CakePHP's conventions. However, just like CakePHP, those assumptions
are configurable. In your `app.php` config file, add the following:

.. code:: php

    <?php
    // app.php
    ...
    \SeoBakery\SeoBakeryPlugin::NAME => [
        'behaviorModels' => ['Articles']
    ],
    ...

With the above config the following assumptions are made about your application:

1. You have a `ArticlesController` controller
2. Your controller has a `view` action
3. Your articleId is the first passed argument to the `view` action

Determining Route
_________________
There are situations where the assumed routing requires more information to work. You can pass the prefix, plugin and
controller like so

.. code:: php

    <?php
    // app.php
    ...
    \SeoBakery\SeoBakeryPlugin::NAME => [
        'behaviorModels' => [
            'Articles' => [
                'prefix' => 'Customers',
                'plugin' => 'Blog',
                'controller' => 'Posts',
            ]
        ]
    ],
    ...


Setting Actions
___________________
If you wish to override the default actions the plugin will track, just add an array of actions in your controller for
the ``behaviorModel`` like so:

.. code:: php

    <?php
    // app.php
    ...
    \SeoBakery\SeoBakeryPlugin::NAME => [
        'behaviorModels' => [
            'Articles' => [
                'actions' => ['display', 'comments']
            ]
        ]
    ],
    ...

Configuring Entity Identifier
_____________________________
By default, the plugin assumes that your entity's primary key is the first passed argument in the action. To override
this behavior, you have 2 options:

1. provide the index of the passed argument variable provided by the CakePHP Request
2. provide a callable that returns the primary key of the entity. Below is an example of both:

.. code:: php

    <?php
    // app.php
    ...
    \SeoBakery\SeoBakeryPlugin::NAME => [
        'behaviorModels' => [
            'Categories' => [
                'identifierFunc' => 1,
            ],
            'Articles' => [
                'actions' => ['display', 'comments'],
                'identifierFunc' => function(array $passedArgs, string $action, Table $table) {
                    if($action === 'display') {
                         $slug = $passedArgs[2];
                         $article = $table->find('slugged', compact('slug'));
                         return $article->id;
                    }

                    if($action === 'comments') {
                        $id = $passedArgs[0];
                        return $id;
                    }
                },
            ]
        ]
    ],
    ...

Configuring MetaData Fallbacks Generators
_________________________________________
The plugin will auto generate fallback metadata (like titles, descriptions, keywords and robots declaration ) for each entity
saved based on metadata generators. These metadata-generator functions are referred to as ``Builder`` functions. Whenever
metadata like `title` or `description` is missing for an entity, it will use the fallback for each datum.

Long story short, each entity starts with a null `meta title` and a fallback `meta title`. The fallback is configurable
and the actual `meta title` is waiting for you to eventually set it. The same goes for `meta description` and `meta keywords`.
The main reason for this "double value" approach is to be able to quickly generate metadata for an entity programmatically,
while at the same time allow for more SEO optimized values to be given at a later time.

Builders are simple callables that are provided to the behaviorModels config. The plugin comes with
:doc:`Builder functions as classes </configuration/builderFunctions>`. Below are some examples on how to override the
default Builder functions:

.. code:: php

    <?php
    // app.php
    ...
    $articleTitle = fn(Article $article, string $action) => $action === 'view' ? $article->title : ucfirst($action).' '.$article->title;
    ...
    \SeoBakery\SeoBakeryPlugin::NAME => [
        'behaviorModels' => [
            'Articles' => [
                'buildTitleFunc' => $articleTitle,
                'buildDescriptionFunc' => function(ArticleEntity $article, string $action) {
                    switch($action) {
                        case 'view':
                            return $article->snippet
                        case 'edit':
                        case 'create':
                            return  ucfirst($action).' '.$article->title
                        default:
                            return null
                    }
                },
                'buildKeywordsFunc' => new \SeoBakery\Builder\SimpleMetaKeywordsBuilder(),
                'buildShouldIndexFunc' => [Article, 'shouldIndex'],
                'buildShouldFollowFunc' => [Article, 'shouldFollow'],
            ]
        ]
    ],
    ...


.. toctree::
   :maxdepth: 2
   :caption: Contents:

   configuration/builderFunctions
