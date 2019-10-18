<?php

namespace Drupal\csv_field_preview\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;

/**
 * Field Formatter.
 *
 * @FieldFormatter(
 *  id = "csv_preview",
 *  label = @Translation("csv: Display the first page"),
 *  description = @Translation("Display the first page of the CSV file."),
 *  field_types = {"file"}
 * )
 */
class CsvPreview extends FormatterBase {

  /**
   * Get and view elements.
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];
    foreach ($items as $delta => $item) {
      if ($item->entity->getMimeType() == 'text/csv') {
        $file_url = file_create_url($item->entity->getFileUri());
        $html = [
          '#type' => 'html_tag',
          '#tag' => 'div',
          '#attributes' => [
            'class' => ['csv-preview'],
            'id' => ['csv-preview-' . $delta],
            'file' => $file_url,
            'style' => ['height: 320px; overflow: auto; width: 100%;'],
          ],
        ];
        $elements[$delta] = $html;
      }
      else {
        $elements[$delta] = [
          '#theme' => 'file_link',
          '#file' => $item->entity,
        ];
      }
    }
    $elements['#attached']['library'][] = 'csv_field_preview/drupal.csv';
    $elements['#attached']['library'][] = 'csv_field_preview/papaparse';
    $elements['#attached']['library'][] = 'csv_field_preview/handsontable';

    return $elements;
  }

}
