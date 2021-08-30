<?php

namespace App\Controller;

use App\Entity\Teachrs;
use App\Entity\Statistics;
use App\Repository\TeachrsRepository;
use App\Repository\StatisticsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiController extends AbstractController
{

     /**
     * @Route("api/teachrs", name="teachrs_all", methods={"GET"})
     */
    public function showAll(TeachrsRepository $teachrsRepository): Response
    {
        $teachrs = $teachrsRepository->findAll();
        return $this->json($teachrs, 200, []);
    }

    /**
     * @Route("api/teachrs/{id}", name="teachr", methods={"GET"})
     */
    public function showItem(Teachrs $teachr): Response
    {
        //$teachrs = $teachrsRepository->findAll();
        return $this->json($teachr, 200, []);
    }


    /** 
    * @Route("api/teachrs", name="teachr_create", methods={"POST"})
    */
    public function create(Request $request,
                          SerializerInterface $serializer,
                          EntityManagerInterface $em,
                          ValidatorInterface $validator,
                          StatisticsRepository $stat)
    {
        $jsonRecu = $request->getContent();

        try {
            $teachr = $serializer->deserialize($jsonRecu, Teachrs::class, 'json');
            $teachr->setCreatedAt(new \DateTime());

            $errors = $validator->validate($teachr);
            if (count($errors) > 0){
                return $this->json($errors, 400);
            }
            $em->persist($teachr);

            //$stat = new Statistics();
            $test = $em->find('App\Entity\Statistics', 1);
            if ($test === null){
                $em->persist(new Statistics());
                $em->flush();
            } 
            //$test = $em->find(Statistics::class, 1); 
            //dd($test->getCounterInsert());
            $test->setCountInsert($test->incrementeCount());
            $em->persist($test);

            $em->flush();

            return $this->json($teachr, 201, []);

        }catch (NotEncodableValueException $e){
            return $this->json([
                'status' => 400,
                'message' => $e->getMessage()
            ]);
        }
     
    } 

    /**
     * @Route("api/teachrs/{id}", name="teachr_update", methods={"PUT"})
     * @param Teachrs $teachr,
     * @param Request $request,
     * @param SerializerInterface $serializer,
     * @param EntityManagerInterface $em,
     * @param ValidatorInterface $validator 
     */
    public function update(
        Teachrs $teachr,
        Request $request,
        SerializerInterface $serializer,
        EntityManagerInterface $em,
        ValidatorInterface $validator) : JsonResponse
    {

    $jsonRecu = $request->getContent();
    //dd($jsonRecu);
        $serializer->deserialize($jsonRecu, Teachr::class, 'json', [AbstractNormalizer::OBJECT_TO_POPULATE => $teachr]);

        $errors = $validator->validate($teachr);
        if (count($errors) > 0)
        {
            return $this->json($errors, 400);
        }
        //$em->persist($teachr);

        $em->flush();

        return new JsonResponse(null, 204);
    } 

    /**
     * @Route("api/teachrs/{id}", name="teachr_delete", methods={"DELETE"})
     * @param Teachr $teachr
     * @param EntityManagerInterface $em
    
     */
    public function delete(
        Teachrs $teachr,
        EntityManagerInterface $em
    ) {
        $em->remove($teachr);
        $em->flush();

        //return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
        return $this->json(null, 204);
    }
}
