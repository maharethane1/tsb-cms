<?php header('Content-type: Application/xml; charset="utf8"', true);

include('connection/connect.php');
include("cms/operations/functions/seoLinkFunction.php");

$site = $_SERVER['HTTP_HOST'];
$day = date("Y-m-d");
$time = date('H:i:s');
$date = $day."T".$time."+00:00";

?>
<urlset
        xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
        xmlns:xhtml="http://www.w3.org/1999/xhtml"
        xsi:schemaLocation="
            http://www.sitemaps.org/schemas/sitemap/0.9
            http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">

    <url>
        <loc>
            https://www.maharethane.com
        </loc>
        <lastmod>
            <?= $date ?>
        </lastmod>
        <changefreq>
            weekly
        </changefreq>
        <priority>
            1.00
        </priority>
    </url>
    <url>
        <loc>
            https://www.maharethane.com/tr/anasayfa
        </loc>
        <lastmod>
            <?= $date ?>
        </lastmod>
        <changefreq>
            weekly
        </changefreq>
        <priority>
            1.00
        </priority>
    </url>
    <url>
        <loc>
            https://www.maharethane.com/en/home
        </loc>
        <lastmod>
            <?= $date ?>
        </lastmod>
        <changefreq>
            weekly
        </changefreq>
        <priority>
            1.00
        </priority>
    </url>
    <url>
        <loc>
            https://www.maharethane.com/tr/hakkimizda
        </loc>
        <lastmod>
            <?= $date ?>
        </lastmod>
        <changefreq>
            weekly
        </changefreq>
        <priority>
            0.9
        </priority>
    </url>
    <url>
        <loc>
            https://www.maharethane.com/en/aboutus
        </loc>
        <lastmod>
            <?= $date ?>
        </lastmod>
        <changefreq>
            weekly
        </changefreq>
        <priority>
            0.9
        </priority>
    </url>
    <url>
        <loc>
            https://www.maharethane.com/tr/portfolyo
        </loc>
        <lastmod>
            <?= $date ?>
        </lastmod>
        <changefreq>
            weekly
        </changefreq>
        <priority>
            1.00
        </priority>
    </url>
    <url>
        <loc>
            https://www.maharethane.com/en/portfolio
        </loc>
        <lastmod>
            <?= $date ?>
        </lastmod>
        <changefreq>
            weekly
        </changefreq>
        <priority>
            1.00
        </priority>
    </url>
    <url>
        <loc>
            https://www.maharethane.com/tr/iletisim
        </loc>
        <lastmod>
            <?= $date ?>
        </lastmod>
        <changefreq>
            mountly
        </changefreq>
        <priority>
            0.6
        </priority>
    </url>
    <url>
        <loc>
            https://www.maharethane.com/en/contact
        </loc>
        <lastmod>
            <?= $date ?>
        </lastmod>
        <changefreq>
            mounthly
        </changefreq>
        <priority>
            0.6
        </priority>
    </url>
    <?php

    $getPortfolioTr = $db->prepare("SELECT a.*, b.adi_tr as kategori_adi_tr, c.adi_en as kategori_adi_en FROM tbl_portfolio as a LEFT JOIN tbl_portfolio_kategori b ON a.kategori_id=b.id LEFT JOIN tbl_portfolio_kategori c ON a.kategori_id=c.id ORDER BY sira");
    $getPortfolioTr->execute();

    while ($portfolio = $getPortfolioTr->fetch(PDO::FETCH_ASSOC)) {

        $catName = slugify($portfolio["kategori_adi_tr"]);
        $companyName = slugify($portfolio["firma"]);
        $portfolioId = $portfolio["id"];
        $url = "https://".$site."/tr/portfolyo/".$catName."/".$companyName."/".$portfolioId;

        ?>

        <url>
            <loc>
                <?= $url ?>
            </loc>
            <lastmod>
                <?= $date ?>
            </lastmod>
            <changefreq>
                weekly
            </changefreq>
            <priority>
                0.7
            </priority>
        </url>

    <?php }

    $getPortfolioEn = $db->prepare("SELECT a.*, b.adi_tr as kategori_adi_tr, c.adi_en as kategori_adi_en FROM tbl_portfolio as a LEFT JOIN tbl_portfolio_kategori b ON a.kategori_id=b.id LEFT JOIN tbl_portfolio_kategori c ON a.kategori_id=c.id ORDER BY sira");
    $getPortfolioEn->execute();

    while ($portfolio = $getPortfolioEn->fetch(PDO::FETCH_ASSOC)) {

        $catName = slugify($portfolio["kategori_adi_en"]);
        $companyName = slugify($portfolio["firma"]);
        $portfolioId = $portfolio["id"];
        $url = "https://".$site."/en/portfolyo/".$catName."/".$companyName."/".$portfolioId;

        ?>

        <url>
            <loc>
                <?= $url ?>
            </loc>
            <lastmod>
                <?= $date ?>
            </lastmod>
            <changefreq>
                weekly
            </changefreq>
            <priority>
                0.7
            </priority>
        </url>

    <?php }

    ?>


</urlset>




