<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Editar Perro</div>

                    <div class="card-body">
                        <form action="{{ route('dog.update', $dog) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label>Nombre</label>
                                <input type="text" name="name" class="form-control" required value="{{ $dog->name }}">
                            </div>

                            <div class="form-group">
                                <label>Sexo:</label>
                                <select name="gender" required value"{{ $dog->gender }}">
                                    <option value="M">Macho</option>
                                    <option value="H">Hembra</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Raza</label>
                                <input type="text" name="race" class="form-control" required value="{{ $dog->race }}">
                            </div>

                            <div class="form-group">
                                <label>Descripción</label>
                                <input type="text" name="description" class="form-control" required value="{{ $dog->description }}">
                            </div>

                            <div class="form-group">
                                <label>Fecha de nacimiento</label>
                                <input type="date" name="date_of_birth" class="form-control" required value="{{ $dog->date_of_birth }}">
                            </div>
<!-- 

                            <div class="form-group">
                                <label>Foto</label>
                                <input type="file" name="photo" class="form-control" required value="{{ $dog->photo }}">
                            </div>
-->
                            <button type="submit" class="btn btn-primary">Confirmar cambios</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
