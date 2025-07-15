<?php
/**
 * Saicosys Technologies Private Limited
 * Copyright (c) 2017-2025, Saicosys Technologies
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.md
 * Redistributions of files must retain the above copyright notice.
 *
 * @author    Saicosys <info@saicosys.com>
 * @copyright Copyright (c) 2017-2025, Saicosys Technologies
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 * @link      https://www.saicosys.com
 * @since     1.0.0
 * @var \App\View\AppView $this
 */
$this->assign('title', $response['title']);
?>
<section class="min-h-screen flex items-center justify-center bg-white">
    <div class="w-full flex flex-col items-center justify-center">
        <div class="mb-6">
            <a class="inline-block" href="/">
                <img class="mx-auto h-40 max-w-full" src="<?= $response['logo'] ?>" alt="<?= h($response['alt']) ?>">
            </a>
        </div>
        <h1 class="text-3xl font-bold mb-2"><?= h($response['alt']) ?></h1>
        <h3 class="text-lg font-semibold mb-2 text-gray-700"><?= $response['title'] ?></h3>
        <p class="mb-0 text-gray-600"><?= $response['message'] ?></p>
    </div>
</section>
