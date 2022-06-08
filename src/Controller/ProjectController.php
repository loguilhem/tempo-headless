<?php

namespace App\Controller;

use App\Entity\Project;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @Route("/api/project", name="api_project_")
 */
class ProjectController extends AbstractFOSRestController
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Rest\Post(
     *     path = "/create",
     *     name = "create",
     * )
     * @Rest\View
     */
    public function create(): JsonResponse
    {
        $response = new JsonResponse();
        $response
            ->setStatusCode(201)
            ->setData('Project created')
        ;

        return $response;

//        $this->em->persist($project);
//        $this->em->flush();
//
//        return $project;
    }

    /**
     * @Rest\Get(
     *     path = "/{id}",
     *     name = "_show",
     *     requirements = {"id"="\d+"}
     * )
     * @Rest\View
     */
    public function show(Project $project): Project
    {
        return $project;
    }

    /**
     * @Rest\Put(
     *     path = "/{id}",
     *     name = "update",
     *     requirements = {"id"="\d+"}
     * )
     * @Rest\View
     */
    public function update(Request $request, Project $project): Project
    {
        $data = json_decode($request->getContent(), true);

        if (NULL !== $data) {
            $project->setName($data->name);

            $this->em->flush();
        }

        return $project;
    }

    /**
     * @Rest\Delete(
     *     path = "/{id}",
     *     name = "delete",
     *     requirements = {"id"="\d+"}
     * )
     * @Rest\View
     */
    public function delete(Project $project): JsonResponse
    {
        $this->em->remove($project);
        $this->em->flush();

        $response = new JsonResponse();
        $response
            ->setStatusCode(201)
            ->setData('Project deleted')
        ;

        return $response;
    }
}
