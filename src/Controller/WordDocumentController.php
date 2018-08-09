<?php

namespace App\Controller;

use App\Entity\Dog;
use App\Entity\Registration;
use App\Entity\Show;
use App\Repository\DogRepository;
use App\Repository\RegistrationRepository;
use App\Repository\ShowClassRepository;
use App\Repository\ShowRepository;
use PhpOffice\PhpWord\Shared\Converter;
use PhpOffice\PhpWord\Writer\Word2007\Element\Image;
use Proxies\__CG__\App\Entity\ShowClass;
use function Symfony\Component\DependencyInjection\Loader\Configurator\expr;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;


class WordDocumentController extends Controller
{
    /**
     * @Route("/word/{show}", name="word_catalogue")
     * @throws \PhpOffice\PhpWord\Exception\Exception
     */
    public function index(Request $request, RegistrationRepository $registrationRepository, DogRepository $dogRepository, Registration $registration, ShowRepository $showRepository, Show $show, ShowClassRepository $classRepository)
    {
        $showId = $show->getId();
        $showRegs = $showRepository->findShowRegistrations($showId);

        $showDate = $show->getDateShow();

        if ($showDate instanceof \DateTime) {
            $dateValue = $showDate->format('Y-m-d');
        }

        foreach ($showRegs as $showReg){
        }

        $registrationsByShow=$registrationRepository->findRegistrationsbyShow($show);

        $classes = $classRepository->findAll();

        // Create a new Word document
        $phpWord = new PhpWord();

        $phpWord->setDefaultFontName('Arial');
        $phpWord->setDefaultFontSize(12);
        $phpWord->setDefaultParagraphStyle(array('spacing' => 150, 'lineHeight' => 1));

        $phpWord->addFontStyle('title1', array('name' => 'Verdana', 'size' => 22, 'bold' => true));
        $phpWord->addFontStyle('title3', array('name' => 'Arial', 'size' => 16, 'bold' => true));
        $phpWord->addParagraphStyle('titlePar',array('bgColor'=>'00FFFF', 'lineHeight' => 1, 'align'=>'center'));

        $section = $phpWord->addSection();
        $header = $section->addHeader();
        $header->addText($show->getShowName());
        $source = 'https://tavogyvunas.lt/wp-content/uploads/2018/01/Lietuvos-angl%C5%B3-buldog%C5%B3-myl%C4%97toj%C5%B3-klubas.png';
        $header->addImage($source,
        array(
            'width'            => Converter::cmToPixel(2),
            'height'           => Converter::cmToPixel(2),
            'positioning'      => 'relative',
            'posHorizontal'    => \PhpOffice\PhpWord\Style\Image::POSITION_HORIZONTAL_RIGHT,
            'posHorizontalRel' => 'margin',
            'posVerticalRel'   => 'line',
            'marginTop'        => 200,
//            'marginLeft'       => Converter::cmToPixel(1.5),
//            'marginTop'        => Converter::cmToPixel(0.55),
        )
    );

        $footer = $section->addFooter();
        $footer->addPreserveText('Page {PAGE} of {NUMPAGES}');

        $section->addText('PARODOS RĖMĖJAS / SPONSOR OF THE SHOW', 'title1', 'titlePar');
        $section->addPageBreak();

        $section->addText('INFORMACIJA APIE PARODĄ / INFORMATION', array('size' => 25, 'align' => 'center'));
        $section->addTextBreak(5);
        $section->addText($showReg->getCity(), array('size' => 16, 'align' => 'center', 'bold' => true));
        $section->addText($dateValue, array('size' => 16, 'align' => 'center'));
        $section->addText('Teisėjas / Judge:', array('size' => 16, 'align' => 'both'));

        foreach ($show->getJudges() as $judge) {
            $section->addText(
                $judge->getFullName().' ' .'('.$judge->getCountry().')',
                array('size' => 20, 'align' => 'both')
            );
        }
        $section->addTextBreak(3);

        $section->addText('Programa / Programme','title1', 'titlePar');

        $section->addPageBreak();

        $section->addText('Parodoje suteikiami titulai / Titles granted at the show', 'title1', 'titlePar');
        $section->addTextBreak(2);

        $fillerTitlesDescriptions = [
            'LT CAC   -   Kandidatas į Lietuvos čempionus / Challenge Certificate for the Lithuanian Champion.',
            'Kl JN‘18 -   2018m. Klubo Jaunimo nugalėtojas / Club Junior Winner.',
            'Kl N‘18  -   2018m. Klubo Nugalėtojas / Club Winner.',
            'Kl VN‘18  -  2018m. Klubo Veteranų nugalėtojas / Club Veteran Winner.',
            'BOB  -  Veislės nugalėtojas / Best of Breed.',
            'BOS  -  Kitos lyties nugalėtojas / Best of Opposite Sex.'];


        foreach ($fillerTitlesDescriptions as $fillerTitlesDescription) {
            $section->addText($fillerTitlesDescription);

        }
        $section->addTextBreak(2);


        $section->addText('Klasės / Classes', 'title1', 'titlePar');
        $section->addTextBreak(3);


        foreach ($classes as $class) {
            $section->addListItem(utf8_decode($class->getClassTitle()), 0);
        }
        $section->addPageBreak();


        $styleTable = array('borderColor'=>'ffffff', //invisible border
            'borderSize'=>0,
            'cellMargin'=>50,
            'width'=>90);

        $catalogue = [
            'male' => [],
            'female'=> []
        ];

        $numbersInCat = []; //stores key - owner // value - dog number in catalogue

        foreach ($registrationsByShow as $registration){
            $sex = $registration->getDog()->getSex();

            if ($registration->getClass()->getClassTitle() != null){
                $class = $registration->getClass()->getClassTitle();
            }
            if (!array_key_exists($class, $catalogue[$sex])){
                    $catalogue [$sex][$class] = [];
                }
                $dog = $registration->getDog();
                $catalogue[$sex][$class][]=$dog;
    }

            $counter = 1;
            foreach ($catalogue as $sex=>$classes) {
                $section->addText(strtoupper($sex), 'title1');
                $section->addTextBreak(3);

                foreach($classes as $class=>$dogs) {

                        $section->addText($class, 'title3');
                    $section->addTextBreak(2);
                        foreach ($dogs as $dog) {

                            $owner = $dog->getOwner()->getFullName();

                                if (!array_key_exists($owner, $numbersInCat )){
                                    $numbersInCat [$owner] =[];
                                }
                            $numbersInCat [$owner][] = $counter;

                            $phpWord->addTableStyle('myTable', $styleTable);

                            $table = $section->addTable('myTable');
                            $table->addRow();
                            $cell = $table->addCell(20);
                            $cell->addText($counter++, array('bold' => true));
                            $cell = $table->addCell(3500);
                            $cell->addText(strtoupper($dog->getRegisteredName()), array('bold' => true));
                            foreach ($dog->getTitles() as $title) {
                                $cell->addText($title->getName());
                            }
                            $cell = $table->addCell(2000);
                            $cell->addText($dog->getPedigreeRegNo());

                            $table->addRow();
                            $cell = $table->addCell(2000);
                            $cell->addText($dog->getColor());
                            $cell = $table->addCell(2000);
                            $cell->addText($dog->getDateOfBirth()->format('Y-m-d'));
//                            $cell = $table->addCell(2000);
//                            foreach ($dog->getTitles() as $title) {
//                                $cell->addText($title->getName(), array('bold' => true));
//                            }
                            $cell = $table->addCell(3500);
                            $cell->addText('S/T.: '. strtoupper($dog->getSire()));
                            $table->addRow();
                            $cell = $table->addCell(3500);
                            $cell->addText('D/M.: '. strtoupper($dog->getDam()));
                            $cell = $table->addCell(2500);
                            $cell->addText('b/veis.: ' . ucfirst($dog->getBreeder()));

                            if ($dog->getOwner()->getFullName() != null) {
                                $cell = $table->addCell(2500);
                                $cell->addText('o/sav.: '. ucfirst($dog->getOwner()->getFullName()));
                            } else {
                                $cell = $table->addCell(2000);
                                $cell->addText('o/sav.:', array('bold' => true));
                            }
                            $section->addTextBreak(3);

                        }
                    }
                }

        $section->addTextBreak(6);
        $section->addText('COMPETITIONS', 'title3', 'titlePar');
        $section->addTextBreak(3);
        $table = $section->addTable('competitions', array('borderSize'=>5, 'cellMargin'=>50));

        foreach ($registrationsByShow as $registration) {
            $competitions = $registration->getCompetitions();

            $dog = $registration->getDog();
            $table->addRow();
            $cell = $table->addCell(3000);
            $cell->addText($dog->getOwner()->getFullName(), array('bold' => true));
            $cell = $table->addCell(3500);
            $cell->addText($dog->getRegisteredName(), array('bold' => true));

            foreach ($competitions as $competition ) {

                $cell = $table->addCell(2000);
                $cell->addText($competition->getCompetitionTitle(), array('bold' => true));
            }
        }

        $section->addPageBreak();

        $section->addText('DALYVIAI / PARTICIPANTS','title1', 'titlePar');
        $section->addTextBreak(3);

        $table = $section->addTable('numInCatTable');

        foreach ($numbersInCat as $owner=>$counters) {

            $table->addRow();
            $cell = $table->addCell(3000);
            $cell->addText(ucfirst($owner));

            foreach($counters as $counter) {

                $cell = $table->addCell(200);
                $cell->addText($counter, array('bold' => true));

                }
            }

        // Saving the document as OOXML file...
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');

        $fileName = 'katalogas_'. $show->getCity().'_'.$dateValue. '.docx';
        $temp_file = tempnam(sys_get_temp_dir(), $fileName);

        // Write in the temporal filepath
        $objWriter->save($temp_file);

        // Send the temporal file as response (as an attachment)
        $response = new BinaryFileResponse($temp_file);
        $response->setContentDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            $fileName
        );

        return $response;
    }
}
