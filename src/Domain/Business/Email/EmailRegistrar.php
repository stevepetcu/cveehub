<?php declare(strict_types=1);

/*
 * This file is part of the CVeeHub application.
 *
 * © Stefan Petcu <contact@stefanpetcu.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace CVeeHub\Domain\Business\Email;

use CVeeHub\Domain\Entity\Email;
use CVeeHub\Infrastructure\Factory\Entity\EmailFactory;
use CVeeHub\Infrastructure\Generator\EntityPublicIdGenerator;
use CVeeHub\Infrastructure\Repository\Entity\EmailRepository;

class EmailRegistrar
{
    private $factory;

    private $repository;

    private $publicIdGenerator;

    public function __construct(
        EmailFactory $factory,
        EntityPublicIdGenerator $publicIdGenerator,
        EmailRepository $repository
    ) {
        $this->factory = $factory;
        $this->publicIdGenerator = $publicIdGenerator;
        $this->repository = $repository;
    }

    public function register()
    {
        // To be implemented.
    }

    public function assignPublicId(Email $email)
    {
        do {
            $email->setPublicId($this->publicIdGenerator->generate());
        } while ($this->repository->findByPublicId($email->getPublicId()));
    }
}
