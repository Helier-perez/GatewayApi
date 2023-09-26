<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class XmlToJsonController extends Controller
{
    public function convert(Request $request)
    {
        $file = $request->file('xml_file');

        if (!$file->isValid()) {
            return response()->json(['error' => 'El archivo no es valido'], 422);
        }

        // Obtener el archivo XML enviado
        $xmlFile = $file->get();
        //Remover comentarios de xml
        $xmlString = preg_replace('/<!--.*?-->/', '', $xmlFile);

        // Leer el contenido del archivo XML y convertirlo en un array asociativo
        $xmlData = simplexml_load_string('<xml>' . $xmlString . '</xml>', 'SimpleXMLElement', LIBXML_NOCDATA);
        $jsonData = json_encode($xmlData);

        // Guardar el archivo JSON en el directorio storage/app/json
        $jsonFileName = str_replace('.xml', '.json', $file->getClientOriginalName());
        Storage::put('json/' . $jsonFileName, json_encode($xmlData, JSON_PRETTY_PRINT));

        // Devolver la respuesta con el JSON generado
        return response()->json(json_decode($jsonData,true));
    }
}
