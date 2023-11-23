<?php

declare(strict_types=1);

namespace Yii2\Asset\Tests;

use Yii;
use Yii2\Asset\PopperAsset;
use Yii2\Asset\PopperCdnAsset;
use yii\web\AssetBundle;
use yii\web\View;

final class AssetTest extends TestCase
{
    public function testPopperAssetSimpleDependency(): void
    {
        $view = Yii::$app->getView();

        $this->assertEmpty($view->assetBundles);

        PopperAsset::register($view);

        $this->assertCount(1, $view->assetBundles);
        $this->assertArrayHasKey(PopperAsset::class, $view->assetBundles);
    }

    public function testPopperAssetRegister(): void
    {
        $view = new View();

        $this->assertEmpty($view->assetBundles);

        PopperAsset::register($view);

        $this->assertCount(1, $view->assetBundles);
        $this->assertInstanceOf(AssetBundle::class, $view->assetBundles[PopperAsset::class]);

        $result = $view->renderFile(__DIR__ . '/Support/main.php');

        $this->assertStringContainsString('popper.js', $result);
    }

    public function testPopperCdnAssetSimpleDependency(): void
    {
        $view = Yii::$app->getView();

        $this->assertEmpty($view->assetBundles);

        PopperCdnAsset::register($view);

        $this->assertCount(1, $view->assetBundles);
        $this->assertArrayHasKey(PopperCdnAsset::class, $view->assetBundles);
    }

    public function testPopperCdnAssetRegister(): void
    {
        $view = new View();

        $this->assertEmpty($view->assetBundles);

        PopperCdnAsset::register($view);

        $this->assertCount(1, $view->assetBundles);
        $this->assertInstanceOf(AssetBundle::class, $view->assetBundles[PopperCdnAsset::class]);

        $result = $view->renderFile(__DIR__ . '/Support/main.php');

        $this->assertStringContainsString(
            <<<HTML
            <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" crossorigin="anonymous" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"></script>
            HTML,
            $result,
        );
    }
}
