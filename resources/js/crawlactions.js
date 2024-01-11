import { ref } from 'vue';
import axios from 'axios';

const message = ref(null);

const storeTaskId = async (taskId, crawlsiteId) => {
  const url = '/store-task-id';
  const data = {
    task_id: taskId,
    crawlsite_id: crawlsiteId,
  };

  try {
    const response = await axios.post(url, data);
    const result = response.data;
    console.log(result);
  } catch (error) {
    console.error('Error:', error);
  }
};

const sendRequest = async (crawlsite) => {
  const url = 'https://localhost:3000/v1/matchlinks';
  const data = {
    Url: crawlsite.url,
    SearchTerms: crawlsite.searchTerms,
    CrawlSiteId: crawlsite.id,
    MaxDepth: 3,
  };

  try {
    const response = await axios.post(url, data);
    const result = response.data;
    console.log(result);
    message.value = JSON.stringify(result, null, 2);

    // Retrieve the ID from the response
    const id = result.task_id;

    if (id) {
      storeTaskId(id, crawlsite.id);
    } else {
      console.error('Task ID is missing');
    }
  } catch (error) {
    console.error('Error:', error);
  }

  return message.value;
};

const storeArticle = async (article) => {
  try {
    const response = await axios.post('/store-article', article);
    const result = response.data;
    console.log(result);
  } catch (error) {
    console.error('Error:', error);
  }
};

const getLinks = async (crawlsite) => {
  const url = `https://localhost:3000/v1/getlinks?crawlsiteid=${crawlsite.id}`;

  try {
    const response = await axios.get(url);
    const result = response.data;
    console.log(result);
    message.value = JSON.stringify(result, null, 2);

    // Save the links to the database
    const urls = result.links.map((link) => link.url);

    const article = {
      urls,
      crawlsite_id: crawlsite.id,
    };

    console.log('article', article);

    await storeArticle(article);
  } catch (error) {
    console.error('Error:', error);
  }

  return message.value;
};

export {
  sendRequest,
  getLinks,
};
