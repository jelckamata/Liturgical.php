<?php

namespace JELCKama\Liturgical;

require __DIR__ . "/vendor/autoload.php";
use Exception;

enum LiturgicalColor: string {
    case Red = "red";
    case White = "white";
    case Gold = "gold";
    case Green = "green";
    case Purple = "purple";
    case Black = "black";
    case Rose = "rose";
    case Blue = "blue";

    public function name(): string {
        return $this->value;
    }
    
    public function cssVer(): string {
        return "--lit_{$this->name()}";
    }

    public function hexColor(): string {
      return match($this){
        LiturgicalColor::Red => "#d90000",
        LiturgicalColor::White => "#ffffff",
        LiturgicalColor::Gold => "#fff176",
        LiturgicalColor::Green => "#32ab38",
        LiturgicalColor::Purple => "#8a2be2",
        LiturgicalColor::Black => "#000000",
        LiturgicalColor::Rose => "#e08282",
        LiturgicalColor::Blue => "#0000f8",
        default => throw new Exception()
      };
    }

    public function squareChar(): string {
      $ret = mb_chr(match($this){
        LiturgicalColor::Red => 0x1f7e5,
        LiturgicalColor::White => 0x2b1b + 1,
        LiturgicalColor::Gold => 0x1f7e5 + 3,
        LiturgicalColor::Green => 0x1f7e5 + 4,
        LiturgicalColor::Purple => 0x1f7e5 + 5,
        LiturgicalColor::Black => 0x2b1b,
        LiturgicalColor::Rose => 0x1f7e5 + 5,
        LiturgicalColor::Blue => 0x1f7e5 + 1,
        default => throw new Exception()
      });

      switch(gettype($ret)) {
        case "string":
          return $ret;
        case "boolean":
          throw new Exception();
        default:
          throw new Exception();
      }
    }
  }

/*
<cssVer(), hexColor(): CSS Variables>
--lit_red: #d90000;
--lit_white: #ffffff;
--lit_gold: #fff176;
--lit_gold_h: #c39000;
--lit_green: #32ab38;
--lit_purple: #8a2be2;
--lit_purple_l: #cf87ff;
--lit_black: #4d5f53;
--lit_rose: #e08282;
--lit_blue: #0000f8;

<squareChar(): Geometric Shape Square>
black: 0x2b1b
white: 0x2b1b + 1
red: 0x1f7e5
blue: 0x1f7e5 + 1
gold: 0x1f7e5 + 3
green: 0x1f7e5 + 4
purple: 0x1f7e5 + 5
*/
?>