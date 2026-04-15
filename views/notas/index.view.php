<?php $validacoes = flash()->get('validacoes') ?>

<div class="bg-base-300 rounded-l-box w-56 flex flex-col divide-y divide-gray-700 overflow-hidden">
    <?php foreach ($notas as $nota) { ?>
        <a href="/notas?id=<?= $nota->id?><?= request()->get('pesquisar', '', '&pesquisar=') ?>" class="
            w-full p-2 cursor-pointer hover:bg-base-200 <?php if ($nota->id == $notaSelecionada->id) { ?> bg-base-200 <?php } ?>
        ">
            <?= $nota->titulo ?> <br/>

            <span class="text-xs">id: <?= $nota->id?></span>
        </a>
    <?php } ?>
</div>

<div class="bg-base-200 rounded-r-box w-full p-10 flex flex-col space-y-6">
    <form action="/nota" method="post" id="form-atualizacao">
        <input type="hidden" name="__method" value="PUT">
        <input type="hidden" name="id" value="<?= $notaSelecionada->id?>">

        <fieldset class="fieldset">
            <legend class="fieldset-legend">Título</legend>
            <input value="<?= $notaSelecionada->titulo?>" name="titulo" type="text" class="input w-full" placeholder="Type here" />
            <?php if (isset($validacoes['titulo'])) { ?>
                <div class="mt-1 text-xs text-error">
                    <?= $validacoes['titulo'][0] ?>
                </div>
            <?php } ?>
        </fieldset>

        <fieldset class="fieldset">
            <legend class="fieldset-legend">Sua nota</legend>
            <textarea name="nota"
                <?php if (! session()->get('mostrar')) { ?>
                    disabled
                <?php } ?>
            class="textarea h-24 w-full" placeholder="Escreva aqui..."><?= $notaSelecionada->nota() ?></textarea>
            <?php if (isset($validacoes['nota'])) { ?>
                <div class="mt-1 text-xs text-error">
                    <?= $validacoes['nota'][0] ?>
                </div>
            <?php } ?>
        </fieldset>

    </form>
    <div class="flex justify-between items-center">
        <form action="/nota" method="POST">
            <input type="hidden" name="__method" value="DELETE" />
            <input type="hidden" name="id" value="<?= $notaSelecionada->id ?>" />
            <button class="btn btn-error" type="submit">Deletar</button>
        </form>
        <button class="btn btn-primary" type="submit" form="form-atualizacao">Atualizar</button>
    </div>
</div>
