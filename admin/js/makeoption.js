$('#cate1').change(function() {
  makeOption($(this), 2, '중분류', $('#cate2'));
});
$('#cate2').change(function() {
  makeOption($(this), 3, '소분류', $('#cate3'));
});
$('#pcode2_1').change(function() {
  makeOption($(this), 2, '중분류', $('#pcode3'));
});


async function makeOption(e, step, category, target) {
  let cate = e.val();
  let data = new URLSearchParams({
    cate: cate,
    step: step,
    category: category
  });
  console.log(data.toString());

  try {
    const response = await fetch('printOption.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded'
      },
      body: data
    });

    if (!response.ok) {
      throw new Error('Network response was not ok');
    }

    const resultText = await response.text();
    console.log(resultText);
    target.html(resultText);
  } catch (error) {
    console.error('Error:', error);
  }
}