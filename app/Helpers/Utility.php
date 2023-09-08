<?php

namespace App\Helpers;

use Illuminate\Support\Str;

class Utility
{
  /**
   * Number Format
   * 
   * @param int|float|double $value Nilai
   * @return string
   */
  public static function numberFormat($value, $decimal = 0)
  {
    return number_format($value, $decimal, ',', '.');
  }

  /**
   * Rupiah Format
   * 
   * @param  int|float|double $value Nilai
   * @return string
   */
  public static function rupiahFormat($value)
  {
    return Str::replace('?', self::numberFormat($value, 2), 'Rp ?');
  }

  /**
   * Rupiah Format Not Decimal
   * 
   * @param  int|float|double $value Nilai
   * @return string
   */
  public static function rupiahFormatNotDecimal($value)
  {
    return Str::replace('?', self::numberFormat($value, 0), 'Rp ?');
  }

  /**
   * Unit Format
   * 
   * @param  int|float|double $value Nilai
   * @param  string $unit Nama Satuan
   * @return string
   */
  public static function unitFormat($value, $unit)
  {
    if (is_null($value)) {
      return '-';
    }

    return Str::replaceArray('?', [self::numberFormat($value), $unit], '? ?');
  }

  /**
   * Percentage Format
   * 
   * @param  int|float|double $value Nilai
   * @return string
   */
  public static function percentageFormat($value)
  {
    return Str::replace('?', str_replace([',', '.'], ['.', ','], round($value, 2)), '?%');
  }
}
