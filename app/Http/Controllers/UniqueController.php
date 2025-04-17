<?php
namespace App\Http\Controllers;

use App\Models\Unique;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class UniqueController extends Controller
{
    /* ------ Список ------ */
    public function index()
    {
        $uniques = Unique::with('project')->latest()->paginate(20);
        return view('uniques.index', compact('uniques'));
    }

    /* ------ Форма создания ------ */
    public function create()
    {
        // берём только проекты с act_enable = 1
        $projects = Project::where('act_enable', true)->pluck('brand_name','id');
        return view('uniques.create', compact('projects'));
    }

    /* ------ Сохранение ------ */
    public function store(Request $r)
    {
        $data = $this->validated($r);
        Unique::create($data);
        return redirect()->route('uniques.index')
            ->with('success','Ակտը ստեղծված է');
    }

    /* ------ Форма редактирования ------ */
    public function edit(Unique $unique)
    {
        $projects = Project::where('act_enable', true)->pluck('brand_name','id');
        return view('uniques.edit', compact('unique','projects'));
    }

    /* ------ Обновление ------ */
    public function update(Request $r, Unique $unique)
    {
        $unique->update( $this->validated($r,$unique->id) );
        return back()->with('success','Փոփոխվեց');
    }

    /* ------ Удаление ------ */
    public function destroy(Unique $unique)
    {
        $unique->delete();
        return back()->with('success','Ջնջվեց');
    }

    /* ------ Экспорт ------ */
    public function export(Unique $unique)
    {
        if (!$unique->can_export) {
            return back()->withErrors('Export is not allowed yet');
        }

        $project = $unique->project;

        // --------- XML ----------
        $xml = '<ExportedAccDocData xmlns="http://www.taxservice.am/tp3/invoice/definitions">';
        $xml .= '<AccountingDocument Version="1.0">
    <Type>3</Type>
    <GeneralInfo><DeliveryDate>'
            . $unique->export_date->format('Y-m-d') . '+04:00</DeliveryDate><Procedure>1</Procedure></GeneralInfo>
    <SupplierInfo><Taxpayer><TIN>06973829</TIN><Name>«ՍՄԱՌԹ» ՍՊԸ</Name></Taxpayer></SupplierInfo>
    <BuyerInfo><Taxpayer><Name>'.e($project->brand_name).'</Name></Taxpayer></BuyerInfo>
    <GoodsInfo>
        <Good><Description>'.e($unique->carayutyan_anun).'</Description>
              <Unit>шт</Unit><Amount>1</Amount>
              <PricePerUnit>'.$unique->gumar.'</PricePerUnit>
              <Price>'.$unique->gumar.'</Price><TotalPrice>'.$unique->gumar.'</TotalPrice>
        </Good>
        <Total><TotalPrice>'.$unique->gumar.'</TotalPrice></Total>
    </GoodsInfo>
</AccountingDocument>';
        $xml .= '</ExportedAccDocData>';

        $fileName = 'unique_'.$unique->id.'.xml';
        $path = storage_path("app/public/$fileName");
        file_put_contents($path,$xml);

        return response()->download($path)->deleteFileAfterSend(true);
    }

    /* ------ Валидация ------ */
    private function validated(Request $r, $id = null): array
    {
        return $r->validate([
            'project_id'        => 'required|exists:projects,id',
            'paymanagir_hamar'  => 'nullable|integer',
            'paymanagir_date'   => 'nullable|date',
            'matucman_date'     => 'nullable|date',
            'carayutyan_anun'   => 'nullable|string|max:255',
            'gumar'             => 'nullable|numeric|min:0',
            'export_date'       => 'nullable|date',
        ]);
    }
}
