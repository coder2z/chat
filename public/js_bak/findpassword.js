$(function () {

	$(".gain-yan").click(function () {
		let telStr = /^(0|86|17951)?(13[0-9]|15[012356789]|166|17[3678]|18[0-9]|14[57])[0-9]{8}$/;
		if (!telStr.test($('#input1').val())) {
			alert("手机号不正确!")
			return;
		}
		$.ajax({
			type: 'post',
			url: "../getCaptcha",
			dataType: "json",
			data: {
				tel: $("#input1").val(),
				type: 1
			},
			success: function (data) {
				if (data.code == 200) {
					alert("成功提交！")
					
				} else {
					alert('输入内容错误！');
				}
			},
			error: function () {

			}
		});
	})

	$('.new-word-submit').click(function (e) {
		var newpassword = $("#input2").val();
		var Verification = $("#input4").val();
		Verification = parseInt(Verification);
		e.preventDefault();
		// 手机号验证
		let telStr = /^(0|86|17951)?(13[0-9]|15[012356789]|166|17[3678]|18[0-9]|14[57])[0-9]{8}$/;
		if (!telStr.test($('#input1').val())) {
			
		}
		// 密码验证
		let passwordStr = /^[a-z0-9]+$/i;
		if (!passwordStr.test($('#input2').val())) {
			
		}
		// 确认密码验证
		if ($('#input2').val() != $('#input3').val()) {
			alert("两次密码不同!")
			return;
		}
		if (!telStr.test($('#input1').val()) || !passwordStr.test($('#input2').val()) || ($('#input4').val() == '')) {
			alert('请正确输入！');
			return;
		}

		$.ajax({
			type: 'post',
			url: "../uploadPassword",
			dataType: "json",
			data: {
				tel: $('#input1').val(),
				code: Verification,
				newPassword: newpassword
			},
			success: function (data) {
				if (data.code == 200) {
					alert("成功提交！")

				}else if(data.code == 100){
					alert(data.data.code);
				}else{
					alert('输入内容错误！');
				}
			},
			error: function () {
			}
		});

	})
})