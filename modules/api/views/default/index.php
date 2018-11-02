<?php

$this->title = 'API Documentation';

/** @var array $documentation */
/** @var $this \yii\web\View */

$this->registerCssFile('//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.13.1/styles/default.min.css');
$this->registerJsFile('//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.13.1/highlight.min.js');

$this->registerJs('hljs.initHighlightingOnLoad();')

?>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Method</th>
            <th>Endpoint</th>
            <th>Description</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($documentation as $endpoint => $info) { ?>
            <tr>
                <td>
                    <?php foreach ($info['methods'] as $method) { ?>
                    <span class="label label-info label-xs"><?= $method ?></span>
                    <?php } ?>
                </td>
                <td><?= $endpoint ?></td>
                <td>
                    <table class="table">
                        <tr>
                            <th>Description:</th>
                            <td><?= $info['description'] ?></td>
                        </tr>
                        <tr>
                            <th>Body Params:</th>
                            <td>
                                <?php if (empty($info['bodyParams'])) { ?>
                                    <i>No params</i>
                                <?php } else { ?>
                                    <table class="table">
                                        <?php foreach ($info['bodyParams'] as $paramName => $validators) { ?>
                                            <tr>
                                                <td><code><?= $paramName ?></code></td>
                                                <td><?= $validators ?></td>
                                            </tr>
                                        <?php } ?>
                                    </table>
                                <?php } ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Success Response Sample:</th>
                            <td><pre><code class="json"><?= $info['responseSample'] ?></code></pre></td>
                        </tr>
                    </table>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>
