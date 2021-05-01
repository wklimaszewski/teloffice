<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use setasign\Fpdi\Fpdi;
use Auth; 

date_default_timezone_set('Europe/Warsaw');

class AgreementsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $pdf = new FPDI('p');

        $pagecount = $pdf->setSourceFile( 'szablon.pdf' );

        $tpl = $pdf->importPage(1);
        $pdf->AddPage();

        $pdf->useTemplate($tpl);

        $pdf->SetFont('Arial');

        //logo
        $pdf->Image('assets/img/logo.png', 5, 5, 45, 11);

        $pdf->SetFontSize('14'); 

        $pdf->SetXY(1, 13.5); 
        //numer umowy
        $stala = 3250; 
        $numer = ($stala+Auth::user()->id)."/".date("Y-m-d");
        $pdf->Cell(208, 10, "Nr ".$numer, 0, 0, 'C'); 

        //data zawarcia umowy
        $pdf->SetFontSize('9'); 
        $pdf->SetXY(62, 34.3); 
        $pdf->Cell(0, 10, date("Y-m-d"), 0, 0, 'L'); 

        $pdf->AddFont('arialbdpl', '','arialbdpl.php'); 
        $pdf->SetFont('arialbdpl'); 
        $pdf->SetFontSize('11');

        //id abonenta
        $pdf->SetXY(80.5, 58.5);
        $pdf->Cell(0, 10, '223231', 0, 1, 'L');
        
        //Imie i nazwisko
        $imieNazwisko = $request->get('name')." ". $request->get('surname'); 
        $pdf->SetXY(51,65.5);
        $pdf->Cell(0, 10, $imieNazwisko, 0, 0, 'L');

        //Adres
        $tekst = $request->input('address');
        $str = iconv('UTF-8','iso-8859-2//TRANSLIT//IGNORE',$tekst);

        $pdf->SetXY(35.5,72.5);
        $pdf->Cell(00, 10, $str, 0, 0, 'L');

        //nr telefonu
        $pdf->SetXY(38,79.5);
        $pdf->Cell(20, 10, $request->input('tel'), 0, 0, 'L');

        //email
        $pdf->SetXY(36,86);
        $pdf->Cell(20, 10, Auth::user()->email, 0, 0, 'L');
        
        $pdf->SetFontSize('8');

        //usluga
        $pdf->SetXY(61,111);
        $pdf->Cell(20, 10, $request->input('usluga'), 0, 0, 'L');

        //cena miesiecznie
        $pdf->SetXY(75,115);
        $pdf->Cell(20, 10, "50,00 PLN", 0, 0, 'L');

        //cena aktywacji
        $pdf->SetXY(73,119);
        $pdf->Cell(20, 10, "1,00 PLN", 0, 0, 'L');

        //email
        $pdf->SetXY(152,139.5);
        $pdf->Cell(20, 10, Auth::user()->email, 0, 0, 'L');

        //pin umowy
        $pdf->SetXY(148.5,157.5);
        $pdf->Cell(20, 10, "455564", 0, 0, 'L');

        //data zakonczenia umowy
        $pdf->SetXY(112.5,187.7);
        $pdf->Cell(20, 10, date("Y-m-d", strtotime('+12 months')), 0, 0, 'L');

        $pdf->SetFontSize('12');

        //podpis klienta
        $pdf->SetXY(25,266);
        $pdf->Cell(60, 10, $imieNazwisko, 0, 0, 'C');

        //podpis firmy
        $pdf->SetXY(125,266);
        $pdf->Cell(60, 10, "Podpis Firmy", 0, 0, 'C');
        $filename="agreements/test";
        $pdf->Output($filename.'.pdf','F');

        return redirect('/create')->with('messege', 'Umowa 231231/05/2021 została zawarta pomyślnie!'); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
