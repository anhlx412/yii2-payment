<?php
/**
 * @link https://github.com/yiiviet/yii2-payment
 * @copyright Copyright (c) 2017 Yii Viet
 * @license [New BSD License](http://www.opensource.org/licenses/bsd-license.php)
 */

namespace yiiviet\payment\nganluong;

use Yii;

use vxm\gatewayclients\ResponseData as BaseResponseData;

/**
 * Lớp ResponseData hổ trợ việc cung cấp, tổng hợp nội dung dữ liệu nhận được từ [[request()]] của [[PaymentGateway]].
 *
 * @method PaymentClient getClient()
 *
 * @property PaymentClient $client
 * @property string $message
 *
 * @author Vuong Minh <vuongxuongminh@gmail.com>
 * @since 1.0
 */
class ResponseData extends BaseResponseData
{

    /**
     * Mảng tổng hợp các message mà Ngân Lượng sẽ trả về.
     *
     * @var array
     */
    public static $responseMessages = [
        '00' => 'Thành công',
        '99' => 'Lỗi chưa xác minh',
        '06' => 'Mã merchant không tồn tại hoặc bị khóa',
        '02' => 'Địa chỉ IP truy cập bị từ chối',
        '03' => 'Mã checksum không chính xác, truy cập bị từ chối',
        '04' => 'Tên hàm API do merchant gọi tới không hợp lệ (không tồn tại)',
        '05' => 'Sai version của API',
        '07' => 'Sai mật khẩu của merchant',
        '08' => 'Địa chỉ email tài khoản nhận tiền không tồn tại',
        '09' => 'Tài khoản nhận tiền đang bị phong tỏa giao dịch',
        '10' => 'Mã đơn hàng không hợp lệ',
        '11' => 'Số tiền giao dịch lớn hơn hoặc nhỏ hơn quy định',
        '12' => 'Loại tiền tệ không hợp lệ',
        '29' => 'Token không tồn tại',
        '80' => 'Không thêm được đơn hàng',
        '81' => 'Đơn hàng chưa được thanh toán',
        '110' => 'Địa chỉ email tài khoản nhận tiền không phải email chính',
        '111' => 'Tài khoản nhận tiền đang bị khóa',
        '113' => 'Tài khoản nhận tiền chưa cấu hình là người bán nội dung số',
        '114' => 'Giao dịch đang thực hiện, chưa kết thúc',
        '115' => 'Giao dịch bị hủy',
        '118' => 'tax_amount không hợp lệ',
        '119' => 'discount_amount không hợp lệ',
        '120' => 'fee_shipping không hợp lệ',
        '121' => 'return_url không hợp lệ',
        '122' => 'cancel_url không hợp lệ',
        '123' => 'items không hợp lệ',
        '124' => 'transaction_info không hợp lệ',
        '125' => 'quantity không hợp lệ',
        '126' => 'order_description không hợp lệ',
        '127' => 'affiliate_code không hợp lệ',
        '128' => 'time_limit không hợp lệ',
        '129' => 'buyer_fullname không hợp lệ',
        '130' => 'buyer_email không hợp lệ',
        '131' => 'buyer_mobile không hợp lệ',
        '132' => 'buyer_address không hợp lệ',
        '133' => 'total_item không hợp lệ',
        '134' => 'payment_method, bank_code không hợp lệ',
        '135' => 'Lỗi kết nối tới hệ thống ngân hàng',
        '140' => 'Đơn hàng không hỗ trợ thanh toán trả góp'
    ];

    /**
     * @inheritdoc
     */
    public function getIsOk(): bool
    {
        if (isset($this['error_code'])) {
            return $this['error_code'] === PaymentGateway::TRANSACTION_STATUS_SUCCESS;
        } else {
            return false;
        }
    }

    /**
     * Phương thức hổ trợ lấy câu thông báo `message` nhận từ Ngân Lượng.
     *
     * @return null|string Trả về NULL nếu như dữ liệu Ngân Lượng gửi về không tồn tại `error_code`,
     * và ngược lại sẽ là câu thông báo dịch từ `error_code`.
     */
    public function getMessage(): ?string
    {
        if (isset($this['error_code'])) {
            return static::$responseMessages[$this['error_code']];
        } else {
            return null;
        }
    }
}
