<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Page Title</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel='stylesheet' type='text/css' media='screen' href='main.css'>
    <script src='main.js'></script>
</head>

<body>
    <div class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <?php if(session('error')): ?>
                        <div class="alert alert-danger">
                            <?php echo e(session('error')); ?>

                        </div>
                    <?php endif; ?>
                    <?php if(session('sucess')): ?>
                        <div class="alert alert-sucess">
                            <?php echo e(session('sucess')); ?>

                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <section>
            <form action="<?php echo e(route('lexar.compiler')); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div id="fileInputGroup" class="mb-3">
                    <label for="code" class="form-label"> Upload C file</label>
                    <input type="file" id="code" name="code" class="form-control">
                </div>
                <button class="btn btn-primary" id="butao"> Analise</button>
            </form>
            <?php if(session('tokens')): ?>
                <div class="mt-5">
                    <h3>Resultado Tabela de Tokens</h3>
                    <p><strong>Total Tokens:</strong> <?php echo e(count(session('tokens'))); ?></p>
                </div>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Tipo</th>
                            <th>valor</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = session('tokens'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $token): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($token['type']); ?></td>
                                <td><?php echo e($token['value']); ?></td>
                                <?php if(isset($token['ID'])): ?>
                                    <td><?php echo e($token['ID']); ?></td>
                                <?php else: ?>
                                    <td></td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            <?php endif; ?>
            <?php if(session('tokens')): ?>
                <div class="mt-5">
                    <h3>Resultado tabela Simbolo</h3>
                </div>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Tipo</th>
                            <th>valor</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = session('tokens'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $simbol): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <?php if(isset($simbol['ID']) && !isset($printedSimbols[$simbol['ID']])): ?>
                                    <td><?php echo e($simbol['ID']); ?></td>
                                    <td><?php echo e($simbol['value']); ?></td>
                                    <?php            $printedSimbols[$simbol['ID']] = true; ?>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </section>
    </div>
</body>

</html>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script><?php /**PATH C:\Codigos\Compiler\resources\views/lexar.blade.php ENDPATH**/ ?>