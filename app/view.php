<?php

/**
 * Project: simple-feedback-form
 * Date: 06.05.16
 * Time: 13:28
 * @author  Dmitriy Zhavoronkov <dimaz.lark@gmail.com>
 * @license GPL-3.0
 * @link    http://artlark.ru/
 */
class View
{
    // All data
    protected static $viewData = [];

    // View filename
    protected $fileName;

    // Array of local variables
    protected $data = [];

    public function __construct($file = null, array $data = null)
    {
        if ($file !== null) {
            $this->setFileName($file);
        }

        if ($data !== null) {
            $this->data = $data + $this->data;
        }
    }

    /**
     * View factory
     * @param string     $file
     * @param array|null $data
     * @return View
     */
    public static function factory($file = null, array $data = null)
    {
        return new View($file, $data);
    }

    /**
     * Get buffer content
     * @param string $fileName
     * @param array  $data
     * @return string
     * @throws Exception
     */
    protected static function capture($fileName, array $data)
    {
        extract($data, EXTR_SKIP);

        if (View::$viewData) {
            extract(View::$viewData, EXTR_SKIP | EXTR_REFS);
        }

        ob_start();

        try {
            include $fileName;
        } catch (Exception $e) {
            ob_end_clean();
            throw $e;
        }

        return ob_get_clean();
    }

    public function __toString()
    {
        try {
            return $this->render();
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Set view file name
     * @param string $file View file name
     * @return $this
     * @throws Exception
     */
    public function setFileName($file)
    {
        $realFileName = APP_PATH . 'views/' . $file . '.php';

        if (file_exists($realFileName) === false) {
            throw new Exception('Requested view not found: ' . $realFileName);
        }

        $this->fileName = $realFileName;

        return $this;
    }

    /**
     * Render view
     * @param mixed $file
     * @return string
     * @throws Exception
     */
    public function render($file = null)
    {
        if ($file !== null) {
            $this->setFileName($file);
        }

        if (empty($this->fileName)) {
            throw new Exception('Filename empty');
        }

        // Combine local and global data and capture the output
        return View::capture($this->fileName, $this->data);
    }
}
