<?php


namespace App\DataPersister;


use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class UserPersister implements DataPersisterInterface
{
    protected $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function supports($data): bool
    {
        return $data instanceof User;
    }

    public function persist($data)
    {
        $password = $data->getPassword();
        $hashed = hash_hmac('sha512', $password, 's5f6sd4f56sd45f46ez1563fes1f5461es465f1se53f132sd1f312s12fth465tr156eh1r56f1zeq56f1qz56415zqe1d56q');
        $data->setPassword($hashed);
        $this->em->persist($data);
        $this->em->flush();
    }

    public function remove($data)
    {
        $this->em->remove($data);
        $this->em->flush();
    }
}