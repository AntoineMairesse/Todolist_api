<?php

namespace App\Controller;

use App\Entity\Block;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiPostController extends AbstractController
{
    protected $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/loginTest/login", name="login_test", methods={"POST"})
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $Requete = $request->getContent();
        $test = json_decode($Requete);
        $email = $test->{'email'};
        $hashed = hash_hmac('sha512', $test->{'password'}, 's5f6sd4f56sd45f46ez1563fes1f5461es465f1se53f132sd1f312s12fth465tr156eh1r56f1zeq56f1qz56415zqe1d56q');
        $repository = $this->getDoctrine()->getRepository(User::class);
        $User = $repository->findOneBy(['password' => $hashed, 'email' => $email]);
        if ($User !== null){
            return $this->json($User, 201);
        }
        $User = $repository->findOneBy(['email' => $email]);
        if ($User !== null){
            return $this->json('BadPassword');
        }
        else{
            return $this->json('UserNotFound');
        }
    }

    /**
     * @Route("/block/user/{id}", name="block_user", methods={"GET"})
     * @param string $id
     * @return Response
     */
    public function blocker(string $id): Response
    {
        $repository = $this->getDoctrine()->getRepository(Block::class);
        $Blocks = $repository->findBy(['user_id' => $id]);
        return $this->json($Blocks, 201);
    }
}
