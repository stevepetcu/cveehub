<?php

use CVeeHub\Presentation\Action\Index\GetAction as GetIndex;
use CVeeHub\Presentation\Action\UserAccount\GetAction as GetUser;
use CVeeHub\Presentation\Action\UserAccount\PostAction as PostUser;
use CVeeHub\Presentation\ContentType\ContentTypeApplicationJson;
use CVeeHub\Presentation\ContentType\ContentTypeApplicationXml;
use CVeeHub\Presentation\ContentType\ContentTypeTextXml;
use CVeeHub\Presentation\Middleware\ContentNegotiation\ContentNegotiationMiddleware;
use CVeeHub\Presentation\Middleware\DataAugmentation\CountryDataAugmentationMiddleware;
use CVeeHub\Presentation\Middleware\DataAugmentation\IndustryDataAugmentationMiddleware;
use CVeeHub\Presentation\Middleware\Validation\UserAccount\PostValidationMiddleware as PostUserAccountValidator;

$countryAugmentationMiddleware = $app->getContainer()->get(CountryDataAugmentationMiddleware::class);
$industryAugmentationMiddleware = $app->getContainer()->get(IndustryDataAugmentationMiddleware::class);
$userCreateMiddleware = $app->getContainer()->get(PostUserAccountValidator::class); // TODO: come up with a better name.

$middleware = compact('countryAugmentationMiddleware', 'industryAugmentationMiddleware', 'userCreateMiddleware');
// TODO: structure this better to avoid having to write on 2 different rows when adding a middleware.
// TODO: extract to a different file. Find a way to know the available middleware w/o looking at that file.

$app->group('', function () use ($middleware) {

    $this
        ->get('/', GetIndex::class)
        ->setName('index')
        ->add(new ContentNegotiationMiddleware(new ContentTypeTextXml(), new ContentTypeApplicationXml()));

    $this
        ->get('/users/{urn:[a-zA-Z0-9\-]+}', GetUser::class)
        ->setName('get-user-account');

    $this
        ->post('/users', PostUser::class)
        ->setName('post-user-account')
        ->add($middleware['userCreateMiddleware']) // IMPORTANT: keep data augmentation middleware below this point.
        ->add($middleware['industryAugmentationMiddleware'])
        ->add($middleware['countryAugmentationMiddleware']);

})->add(new ContentNegotiationMiddleware(new ContentTypeApplicationJson()));
