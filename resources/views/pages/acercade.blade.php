@extends('layouts.app')

@section('header')
<div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
  Acerca de Nosotros
</div>
@endsection

@section('content')
<div class="font-noto text-wrap max-w-5xl mx-auto">
  Hola, me llamo Ramuel González, claro que ese es mi nick o seudonimo. Les contaré un poco de mi:<br>
  programador, analista de sistemas, ingeniería en informática que no terminé. Soy chileno con algunos años en
  Paris.
  Hago sistemas web para entretenerme y mantener mi mente ocupada en lo que me gusta.
  Algunos de los sistemas que he creado son: <br>
  ingeniería interna conversiva de sistemas sociales en decadencia.<br>
  ordenar y alinear los rabo de nubes para que sean más productivos.<br>
  asegurar los tiempos para que Principito llegue a la hora especificada.<br>
  analizar el desempeño de las guerras para que sean productivas tanto en vidas como en esperanza de vida, algo
  complicado últimamente.<br>
  si requieres de un masaje de esperanza y fortaleza puedes escribirme a ramuelcl, puedes elejir lo que quieras
</div>
@endsection

@section('footer')
<p>&copy; {{ date('Y') }} Guzanet. Ramuel González</p>
@endsection