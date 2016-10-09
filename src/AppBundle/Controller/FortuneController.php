<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Category;

class FortuneController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function homepageAction(Request $request)
    {
        $categoryRepository = $this->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:Category');

        /*$categories = $categoryRepository->findAllOrdered();*/

        $search = $request->query->get('q');
        if ($search){
            $categories = $categoryRepository->search($search);
        }else{
            $categories = $categoryRepository->findAllOrdered();
        }

        return $this->render('fortune/homepage.html.twig',[
            'categories' => $categories
        ]);


    }

    /**
     * @Route("/category/{id}", name="category_show")
     */
    public function showCategoryAction($id)
    {
        $categoryRepository = $this->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:Category');

        /*$category = $categoryRepository->find($id);*/

        $category = $categoryRepository->findWithFortunesJoins($id);

        $fortuneData = $this->getDoctrine()
                ->getRepository('AppBundle:FortuneCookie')
                ->CountNumberPrintedForCategory($category);

        $fortunePrinted = $fortuneData['fortunePrinted'];
        $fortuneAverage = $fortuneData['fortuneAverage'];
        $categoryName = $fortuneData['name'];

        /*var_dump($fortuneData);die;*/

        if (!$category) {
            throw $this->createNotFoundException();
        }

        return $this->render('fortune/showCategory.html.twig',[
            'category' => $category,
            'fortunePrinted' => $fortunePrinted,
            'fortuneAverage' => $fortuneAverage,
            'categaotyName' => $categoryName
        ]);
    }
}
