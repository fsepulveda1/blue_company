<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Category;
use AppBundle\Entity\Product;
use AppBundle\Entity\Tag;
use AppBundle\Form\FileUploadType;
use AppBundle\Form\ProductType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use JMS\DiExtraBundle\Annotation as DI;


class DefaultController extends Controller
{
    /**
     * @var string
     * @DI\Inject("%kernel.cache_dir%")
     */
    public $cacheDir;

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine();
        $products = $em->getRepository('AppBundle:Product')->findAll();
        return $this->render('default/index.html.twig',['products'=>$products]);
    }

    /**
     * @Route("/validateXLS", name="validateXLS")
     */
    public function validateXLSAction(Request $request)
    {
        try {
            $data = [];
            $form = $this->createForm(FileUploadType::class,$data);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $data = $form->getData();

                /** @var $file UploadedFile **/
                $file = $data['file'];
                $fileName = 'file_temp_contracts.'.$file->getClientOriginalExtension();
                // Move the file to the directory where brochures are stored
                $file->move(
                    $this->cacheDir,
                    $fileName
                );

                /** @var $excelFile \PHPExcel */
                $excelFile = $this->get('phpExcel')->createPHPExcelObject($this->cacheDir.'/'.$fileName);
                $worksheets = $excelFile->getWorksheetIterator();
                foreach ($worksheets as $worksheet) {
                    $lastColumn = $worksheet->getHighestDataColumn();
                    foreach($worksheet->getRowIterator() as $rowIndex => $row) {
                        $array = $worksheet->rangeToArray('A'.$rowIndex.':'.$lastColumn.$rowIndex,null,false,false,true);
                        $errors[] = $this->validateCellsExcel($array);
                    }
                }
                return new Response(1);

            } else {
                return new Response($this->renderView('default/form_file.html.twig', ['form' => $form->createView()]),202);
            }
        }
        catch(\Exception $e) {
            throw $e;
        }
    }

    /**
     * @Route("/form_product", name="form_product")
     */
    public function formProductAction(Request $request)
    {
        try {
            $product = new Product();
            $form = $this->createForm(ProductType::class, $product);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $file = $product->getImage();
                $fileName = md5(uniqid()) . '.' . $file->guessExtension();

                $file->move(
                    $this->getParameter('url_img_product'),
                    $fileName
                );
                $product->setImage($fileName);

                $em = $this->getDoctrine()->getManager();
                $em->persist($product);
                if(!empty($product->getFoodProduct())) {
                    $em->persist($product->getFoodProduct()->setProduct($product));
                }
                $em->flush();

                return new Response('Producto guardado correctamente',201);
            } else {
                return new Response($this->renderView('default/form_product.html.twig', ['form' => $form->createView()]),202);
            }
        }
        catch(\Exception $e) {
            throw $e;
        }
    }

    /**
     * @Route("/show_more", name="show_more")
     */
    public function showMoreAction(Request $request) {
        $id = $request->get('id');
        $product = $this->getDoctrine()->getRepository('AppBundle:Product')->find($id);
        return $this->render('default/modal.information.html.twig', ['product' => $product]);
    }

    private function validateHeaders($arrayHeader) {

    }

    private function validateCellsExcel($arrayData) {
        foreach ($arrayData as $keyColumn=>$columnData) {
            foreach($columnData as $keyRow => $cells) {
                switch($keyRow) {
                    case 0: //codigo tecnico

                        break;
                    case 1: //rut proveedor

                        break;
                    case 2: //numero contrato

                        break;
                    case 3: //fecha de inicio

                        break;
                    case 4: //fecha de termino

                        break;
                    case 5: //documentación compra

                        break;
                    case 6: //codigo sucursal

                        break;
                    case 7: //centro de costo

                        break;
                    case 8: //tipo de moneda

                        break;
                    case 9: //valor

                        break;
                    case 10: //SLA evaluador

                        break;
                    case 11: //SLA OC

                        break;
                    case 12: //SLA proveedor

                        break;
                    case 13: //SLA producto

                        break;
                    case 14: //SLA despacho

                        break;
                }
            }
        }
    }
}
