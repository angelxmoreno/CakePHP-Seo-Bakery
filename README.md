# SeoBakery plugin for CakePHP
[![codecov](https://codecov.io/gh/angelxmoreno/CakePHP-Seo-Bakery/branch/main/graph/badge.svg?token=CSTUPF7TQA)](https://codecov.io/gh/angelxmoreno/CakePHP-Seo-Bakery?utm_source=gh)
[![Codacy Badge](https://app.codacy.com/project/badge/Grade/635bae4673c044299f7bd2b9f19d9f71)](https://app.codacy.com/gh/angelxmoreno/CakePHP-Seo-Bakery/dashboard?utm_source=gh&utm_medium=referral&utm_content=&utm_campaign=Badge_grade)

Plugin is `currently in phase 6` of development. Find me in the [CakePHP Slack channel](https://cakesf.slack.com/archives/D267RHJAH)

## Another CakePHP SEO Plugin? Why?
During the years I've come across a few CakePHP SEO plugins that served as amazing drop-in solutions for MVP apps. However,
they all seemed to focus on one or two parts of SEO and not a complete solution nor advanced features.

This plugin aims at being a solution for all things SEO from meta-tags to Sitemaps while also being a drop-in solution.

It offers:
- Component - for fetching stored metadata
- ViewHelper - for rendering metadata
- Behavior - for adding templated metadata as a fallback
- Command - for back filling metadata for already existing entities
- ChatGPT suggestions to auto-generate metadata
- Storage of metadata associated with any Entity
- Configurable

## Development progress
### Phase one: MVP
Phase one focuses on delivering the MVP of the plugin. It allows the ability to manage
1. Meta tags: titles, description, keywords
2. Robot tags: nofollow/follow, index/noindex
3. canonical urls with 301 redirects
4. providing metadata fallbacks via behavior
#### Todos
- [X] Create Table classes to store data
- [X] Create Behavior to attach model entities
- [X] Create component to set/load vars
- [X] Create Helper to set/render vars
- [X] Create command to back-fill metadata

### Phase 2: Pages and Index views
#### Todos
- [X] Solve for Pages controller
- [X] Solve for Index views

### Phase 3: Dashboard
#### Todos
- [X] Create Controller/Views for the dashboard

### Phase 4: Open Schema & Twitter Cards
#### Todos
- [X] Add open schema data
- [X] Add Twitter cards data

### Phase 5: Robots.txt & Sitemaps
- [X] Create Robots controller
- [X] Create Sitemaps controller

### Phase 6: ChatGPT suggestions
#### Todos
- [ ] Integrate ChatGPT
- [ ] Create `Prompt Config` for mapping suggestions to SeoMetadata

## Requirements
- CakePHP 4.x
- PHP 7.2+

## Installation
You can install this plugin into your CakePHP application using [composer](https://getcomposer.org).
The recommended way to install this package using composer is:
```
composer require angelxmoreno/seo-bakery
```
Next, load the plugin via the CakePHP pluin shell:
```
bin/cake plugin load SeoBakery
```
Finally, create the plugin tables:
```
bin/cake migrations migrate -p SeoBakery
```
## Documentation
see https://seobakery.readthedocs.io/

## Bugs & Feedback
http://github.com/angelxmoreno/SeoBakery/issues

## License
Licensed under [the MIT License](https://opensource.org/license/mit/). Redistributions of the source code included in
this repository must retain the copyright notice found in each file.
